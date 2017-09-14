<?php

namespace App\Http\Controllers;

use App\Notifications\TakenOrder;
use Illuminate\Http\Request;
use App\Order;
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
	public function add()
	{
		return view('orders.add');
	}
	
	protected function create(Request $request)
	{
		if (Order::all()->count()) {
			$lastOrderId = DB::table('orders')->orderBy('id', 'desc')->first()->id;
		} else {
			$lastOrderId = 0;
		}
		
		$status = 'published';
		
		$data = $request->all();
		
		$data['time_of_receipt'] = date("Y-m-d H:i:s");
		
		$pointA = explode(', ', $data['coordinate_a']);
		$pointB = explode(', ', $data['coordinate_b']);
		
		$order = new Order();
		$order->id = $lastOrderId + 1;
		$order->quantity = $data['quantity'];
		$order->width = $data['width'];
		$order->height = $data['height'];
		$order->depth = $data['depth'];
		$order->weight = $data['weight'];
		$order->time_of_receipt = $data['time_of_receipt'];
		$order->description = $data['description'];
		$order->distance = $data['distance'];
		$order->name_receiver = $data['name_receiver'];
		$order->phone_receiver = $data['phone_receiver'];
		$order->email_receiver = $data['email_receiver'];
		$order->address_a = $data['address_a'];
		$order->address_b = $data['address_b'];
		$order->price = $data['price'];
		$order->status = $status;
		$order->coordinate_a = new Point(trim($pointA[0], "("), trim($pointA[1], ")"));
		$order->coordinate_b = new Point(trim($pointB[0], "("), trim($pointB[1], ")"));
		$order->user_id = $data['user_id'];
		$order->save();
		
		$userOrder = new UserOrder();
		$userOrder->user_id = Auth::user()->id;
		$userOrder->order_id = $lastOrderId + 1;
		$userOrder->role = 'client';
		$userOrder->save();
		
		/*$order = Order::first();
		$lat = $order->coordinate_a->getLat();	// 40.7484404
		$lng = $order->coordinate_a->getLng();	// -73.9878441
		dump($lat);
		dump($lng);*/
		
		$request->session()->flash('previous-route', Route::current()->getName());
		
		return redirect('/');
	}
	
	public function takenOrder($token)
	{
		$status = 'taken';
		$order = Order::where('taken_token', $token)->where('status', 'accepted')->get();
		
		if ($order->isEmpty()) {
			return redirect('/');
		}
		
		foreach ($order as $value) {
			$value->status = $status;
			$value->delivered_token = md5($value->taken_token);
			if ($value->save()) {
				Notification::send(User::find($value->user_id), new TakenOrder($value));
			}
		}
		
		return redirect()->route('client');
		
	}
	
	public function changeStatus(Request $request)
	{
		$status = 'accepted';
		$orderId = $request->order_id;
		
		$order = new Order();
		$orderFind = $order->find($orderId);
		$orderFind->status = $status;
		$orderFind->save();
	}
	
	public function allSeen()
	{
		foreach (auth()->user()->notifications as $note) {
			$note->markAsRead();
		}
	}
}
