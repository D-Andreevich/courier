<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class OrderController extends Controller
{
	
	public function add()
	{
		return view('orders.add');
	}
	
	protected function create(Request $request)
	{
		$status = 'published';
		
		$data = $request->all();
		
		$data['time_of_receipt'] = date("Y-m-d H:i:s");
		
		$pointA = explode(', ', $data['coordinate_a']);
		$pointB = explode(', ', $data['coordinate_b']);
		
		$order = new Order();
		$order->user_id = $data['user_id'];
		$order->quantity = $data['quantity'];
		$order->width = $data['width'];
		$order->height = $data['height'];
		$order->depth = $data['depth'];
		$order->weight = $data['weight'];
		$order->time_of_receipt = $data['time_of_receipt'];
		$order->description = $data['description'];
		$order->name_receiver = $data['name_receiver'];
		$order->phone_receiver = $data['phone_receiver'];
		$order->email_receiver = $data['email_receiver'];
		$order->address_a = $data['address_a'];
		$order->address_b = $data['address_b'];
		$order->price = $data['price'];
		$order->status = $status;
		$order->coordinate_a = new Point(trim ($pointA[0],"("), trim ($pointA[1],")"));
		$order->coordinate_b = new Point(trim ($pointB[0],"("), trim ($pointB[1],")"));
		$order->save();

        /*$order = Order::first();
        $lat = $order->coordinate_a->getLat();	// 40.7484404
        $lng = $order->coordinate_a->getLng();	// -73.9878441
		dump($lat);
		dump($lng);*/
		$request->session()->flash('previous-route', Route::current()->getName());
		
		return redirect('/');
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
	
}
