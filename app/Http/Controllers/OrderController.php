<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use App\Notifications\AcceptOrder;
use App\Notifications\DeliveredOrder;
use App\Notifications\DenyOrder;
use App\Notifications\TakenOrder;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\User;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
	/**
	 * Show add order page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('orders.add');
	}

	/**
	 * Create order for Auth user
	 *
	 * @param Request $request *
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	protected function create(Request $request)
	{
		$user = User::find(auth()->user()->id);
		$data = $request->all();

		$data['time_of_receipt'] = date("Y-m-d H:i:s");
		$pointA = explode(', ', $data['coordinate_a']);
		$pointB = explode(', ', $data['coordinate_b']);

		$order = new Order([
			'quantity' => $data['quantity'],
			'width' => $data['width'],
			'height' => $data['height'],
			'depth' => $data['depth'],
			'weight' => $data['weight'],
			'time_of_receipt' => $data['time_of_receipt'],
			'description' => $data['description'],
			'distance' => $data['distance'],
			'name_receiver' => $data['name_receiver'],
			'phone_receiver' => $data['phone_receiver'],
			'email_receiver' => $data['email_receiver'],
			'address_a' => $data['address_a'],
			'address_b' => $data['address_b'],
			'price' => $data['price'],
			'coordinate_a' => new Point(trim($pointA[0], "("), trim($pointA[1], ")")),
			'coordinate_b' => new Point(trim($pointB[0], "("), trim($pointB[1], ")")),
			'status' => 'published'
		]);

		// Save order with pivot table
		$user->orders()->save($order);

		// Create a flash session for NOTY.js
		$request->session()->flash('previous-route', Route::current()->getName());

		return redirect()->route('home');
	}

	/**
	 * Courier accepted the order
	 *
	 * @param Request $request
	 */
	public function accept(Request $request)
	{
		$order = Order::find($request->order_id);
		$order->courier_id = $request->courier_id;
		$order->status = 'accepted';
		$order->taken_token = md5($request->user_id . $request->order_id . $request->courier_id);

		if ($order->save()) {

			// Create notification for database and Streamlab
			$courier = User::find($request->courier_id);
			$client = User::find($request->user_id);
			$data = $courier->name . ' принял Ваш заказ #' . $request->order_id;

			Notification::send($client, new AcceptOrder($order));
			StreamLabFacades::pushMessage('test', 'AcceptOrder', $data);

			// Create a flash session for NOTY.js
			session()->flash('accepted_order', true);
		}
	}

	/**
	 * Confirm order using the taken_token
	 *
	 * @param $id
	 * @param $token
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function taken($id, $token)
	{
		$orderModel = Order::where('taken_token', $token)->where('status', 'accepted')->get();

		if ($orderModel->isEmpty()) {

			// Create a flash session for NOTY.js
			session()->flash('empty_taken_token', true);

			return redirect()->route('home');
		}

		if (auth()->user()) {

			foreach ($orderModel as $order) {
				if (auth()->user()->id === $order->courier_id) {
					$order->status = 'taken';
					$order->delivered_token = md5($order->taken_token) . $id;

					if ($order->save()) {

						// Create notification for database and Streamlab
						$courier = User::find($order->courier_id);
						$client = User::find($id);
						$data = 'Курьер ' . $courier->name . ' забрал Ваш заказ #' . $order->id;

						Notification::send($client, new TakenOrder($order));
						StreamLabFacades::pushMessage('test', 'TakenOrder', $data);

						// Send email to receiver
						Mail::to($order->email_receiver)->send(new ConfirmOrder($order));

						// Create a flash session for NOTY.js
						session()->flash('taken_order', true);
					}
				} else {

					// Create a flash session for NOTY.js
					session()->flash('not_this_courier', true);

					return redirect()->route('home');
				}
			}
		} else {

			// Create a flash session for NOTY.js
			session()->flash('not_auth_courier', true);

			return redirect('/login');
		}

		return redirect()->route('client_active');
	}

	/**
	 *  Confirm taken order by receiver
	 *
	 * @param $token
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delivered($token)
	{
		$orderModel = Order::all()->where('status', 'taken')->where('delivered_token', $token);

		if (!$orderModel->isEmpty()) {
			foreach ($orderModel as $order) {
				$order->status = 'completed';

				if ($order->save()) {

					// Create notification for database and Streamlab
					$clientId = substr($token, -1);
					$client = User::find($clientId);
					$data = 'Курьер ' . User::find($order->courier_id)->name . ' доставил Ваш заказ #' . $order->id;

					Notification::send($client, new DeliveredOrder($order));
					StreamLabFacades::pushMessage('test', 'DeliveredOrder', $data);

					// Create a flash session for NOTY.js
					session()->flash('rate_courier', true);
					session()->put('courier_id', $order->courier_id);
				}
			}
		} else {

			// Create a flash session for NOTY.js
			session()->flash('empty_receive_token', true);

			return redirect()->route('home');
		}

		return redirect()->route('home');
	}

	/**
	 * Deny the order by courier
	 *
	 * @param Request $request
	 */
	public function deny(Request $request)
	{
		$order = Order::find($request->order_id);
		$order->status = 'published';
		$order->courier_id = 0;
		$order->taken_token = null;

		if ($order->save()) {

			// Create notification for database and Streamlab
			$client = User::find($request->user_id);
			$courier = User::find($request->courier_id);
			$data = 'Курьер ' . $courier->name . ' отменил Ваш заказ #' . $request->order_id;

			Notification::send($client, new DenyOrder($order));
			StreamLabFacades::pushMessage('test', 'DenyOrder', $data);

			// Create a flash session for NOTY.js
			session()->flash('deny_order', true);
		}
	}

	/**
	 * Remove the order by client
	 *
	 * @param Request $request
	 */
	public function remove(Request $request)
	{
		$order = Order::find($request->order_id);

		if ($order->status === 'published') {
			$order->status = 'removed';
			$order->save();

			// Create a flash session for NOTY.js
			session()->flash('remove_order', true);

		} else {

			// Create a flash session for NOTY.js
			session()->flash('deny_remove_order', true);
		}
	}

	/**
	 * Able to make unread notifications
	 */
	public function allSeen()
	{
		foreach (auth()->user()->notifications as $note) {
			$note->markAsRead();
		}
	}
}
