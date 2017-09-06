<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

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

		Order::create([
			'user_id' => $data['user_id'],
			'quantity' => $data['quantity'],
			'width' => $data['width'],
			'height' => $data['height'],
			'depth' => $data['depth'],
			'weight' => $data['weight'],
			'time_of_receipt' => $data['time_of_receipt'],
			'description' => $data['description'],
			'name_receiver' => $data['name_receiver'],
			'phone_receiver' => $data['phone_receiver'],
			'email_receiver' => $data['email_receiver'],
			'address_a' => $data['address_a'],
			'address_b' => $data['address_b'],
			'price' => $data['price'],
            'coordinate_a' => $data['address_a'],
            'coordinate_b' => $data['address_b']
		]);
		
		$request->session()->flash('previous-route', Route::current()->getName());
		
		return redirect('/');
	}

    public function store()
    {
        $bushWalk = Bushwalk::create(Request::except('startPoint'));
        $myPoint = Request::input('startPoint');
        $bushWalk->startPoint = \DB::raw($myPoint);
        $bushWalk->save();
    }
}
