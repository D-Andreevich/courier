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
		$data = $request->all();
		
		$data['time_of_receipt'] = date("Y-m-d H:i:s");
		
		$pointA= explode( ', ', $data['coordinate_a']);
		$pointB= explode( ', ', $data['coordinate_b']);
		
//		Order::create([
//			'user_id' => $data['user_id'],
//			'quantity' => $data['quantity'],
//			'width' => $data['width'],
//			'height' => $data['height'],
//			'depth' => $data['depth'],
//			'weight' => $data['weight'],
//			'time_of_receipt' => $data['time_of_receipt'],
//			'description' => $data['description'],
//			'name_receiver' => $data['name_receiver'],
//			'phone_receiver' => $data['phone_receiver'],
//			'email_receiver' => $data['email_receiver'],
//			'address_a' => $data['address_a'],
//			'address_b' => $data['address_b'],
//			'price' => $data['price'],
//			'coordinate_a' => new Point($pointA[0],$pointA[1]),
//			'coordinate_b' => new Point($pointB[0],$pointB[1])
//		]);
		
        $address= new Order();
        $address->user_id =  $data['user_id'];
        $address->quantity =  $data['quantity'];
        $address->width =  $data['width'];
        $address->height =  $data['height'];
        $address->depth =  $data['depth'];
        $address->weight =  $data['weight'];
        $address->time_of_receipt =  $data['time_of_receipt'];
        $address->description =  $data['description'];
        $address->name_receiver =  $data['name_receiver'];
        $address->phone_receiver =  $data['phone_receiver'];
        $address->email_receiver =  $data['email_receiver'];
        $address->address_a =  $data['address_a'];
        $address->address_b =  $data['address_b'];
        $address->price =  $data['price'];

        $address->coordinate_a = new Point($pointA[0],$pointA[1]);
        $address->coordinate_b = new Point($pointB[0],$pointB[1]);
        $address->save();
		
		$request->session()->flash('previous-route', Route::current()->getName());
		
		return redirect('/');
	}
	
}
