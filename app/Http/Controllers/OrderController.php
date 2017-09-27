<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use App\Notifications\DeliveredOrder;
use App\Notifications\DenyOrder;
use App\Notifications\TakenOrder;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\DB;
use App\UserOrder;
use App\User;
use Illuminate\Support\Facades\Auth;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;


class OrderController extends Controller
{
	/**
	 * Add the order
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('orders.add');
	}
	
	/**
	 * @param Request $request
	 *
	 * Create order for Auth user
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
	 * @param Request $request
	 *
	 *  Courier accepted the order
	 */
	public function accept(Request $request)
	{
		$order = Order::find($request->order_id);
		$order->courier_id = $request->courier_id;
		$order->status = 'accepted';
		$order->taken_token = md5($request->user_id . $request->order_id . $request->courier_id);
		$order->save();
		
		// Create a flash session for NOTY.js
		session()->flash('accepted_order', true);

//			if ($acceptedOrder->save()) {
////				Notification::send($client, new AcceptOrder($acceptedOrder));
////				$data = $courier->name . ' принял Ваш заказ #' . $acceptedOrder->order_id;
////				StreamLabFacades::pushMessage('test' , 'AcceptOrder' , $data);
//			}
		
		//return redirect('/cabinet/courier');
	}
	
	/**
	 * @param $token
	 *
	 *  Confirm order using the taken_token
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function taken($token)
	{
		$orderModel = Order::where('taken_token', $token)->where('status', 'accepted')->get();
		
		if ($orderModel->isEmpty()) {
			// TODO noty
			return redirect()->route('home');
		}
		
		if (auth()->user()) {
			foreach ($orderModel as $order) {
				if (auth()->user()->id === $order->courier_id) {
					$order->status = 'taken';
					$order->delivered_token = md5($order->taken_token);
					if ($order->save()) {
						//Notification::send(User::find($value->user_id), new TakenOrder($value));
						Mail::to($order->email_receiver)->send(new ConfirmOrder($order));
						
						// Create a flash session for NOTY.js
						session()->flash('taken_order', true);
					}
				} else {
					// Create a flash session for NOTY.js
					session()->flash('deny_courier', true);
					
					return redirect()->route('home');
				}
			}
		} else {
			// TODO noty
			return redirect('/login');
		}
		
		return redirect()->route('client');
	}
	
	/**
	 * @param $token
	 *
	 *  Confirm taken order by receiver
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
					session()->flash('rate_courier', true);
					session()->put('courier_id', $order->courier_id);
//					Notification::send(User::find($order->user_id), new DeliveredOrder($order));
//
//					foreach ($courierModel as $courier) {
//						$data = 'Курьер ' . User::find($courier->user_id)->name . ' доставил Ваш заказ #' . $order->id;
//					}
//					StreamLabFacades::pushMessage('test', 'DeliveredOrder', $data);
				}
			}
		} else {
			// Todo Noty
			return redirect()->route('home');
		}
		
		return redirect()->route('home');
	}
	
	/**
	 * @param Request $request
	 *
	 * Deny the order by courier
	 */
	public function deny(Request $request)
	{
		$order = Order::find($request->order_id);
//		$client = User::find($order->user_id);
//		$courierModel = UserOrder::all()->where('order_id', $request->order_id)->where('role', 'courier');
//
//		Notification::send($client, new DenyOrder($order));
//
//		foreach ($courierModel as $courier) {
//			$data = 'Курьер ' . User::find($courier->user_id)->name . ' отменил Ваш заказ #' . $order->id;
//			StreamLabFacades::pushMessage('test', 'DenyOrder', $data);
//			$courier->delete();
//		}
		
		session()->flash('deny_order', true);
		
		$order->status = 'published';
		$order->courier_id = 0;
		$order->taken_token = null;
		$order->save();
	}
	
	/**
	 * @param Request $request
	 *
	 *  Remove the order by client
	 */
	public function remove(Request $request)
	{
		$order = Order::find($request->order_id);
		$order->status = 'removed';
		$order->save();
		
		// Create a flash session for NOTY.js
		session()->flash('remove_order', true);
	}
	
	public function allSeen()
	{
		foreach (auth()->user()->notifications as $note) {
			$note->markAsRead();
		}
	}
}
