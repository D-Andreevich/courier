<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
	
    public function add()
    {
    	return view('orders.add');
    }
    
    protected function create(Request $request)
    {
    	$data = $request->all();
    	
	    return Order::create([
		    'user_id' => $data['user_id'],
		    'quantity' => $data['quantity'],
		    'width' => $data['width'],
		    'height' => $data['height'],
		    'depth' => $data['depth'],
		    'weight' => $data['weight'],
		    'description' => $data['description'],
		    'is_vehicle' => $data['is_vehicle'],
		    'name_receiver' => $data['name_receiver'],
		    'phone_receiver' => $data['phone_receiver'],
		    'email_receiver' => $data['email_receiver'],
		    'address_a' => $data['address_a'],
		    'address_b' => $data['address_b'],
		    'price' => $data['price']
	    ]);
	    
	    //return redirect('/');
    }
}
