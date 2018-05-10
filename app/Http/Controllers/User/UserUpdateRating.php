<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use App\Order;
use Illuminate\Http\Request;

class UserUpdateRating extends Controller
{
	/**
	 * Show users profile
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function __invoke(Request $request)
	{
		$user = User::find($request->courierId);
		$user->total_rating += $request->rating;
		$user->total_rates += $request->userCount;
		$user->rating = $user->total_rating / $user->total_rates;
		$user->save();
		
		$order = Order::find($request->orderId);
		$order->is_rate = 1;
		
		if ($order->save()) {
			
			// Create a flash session for NOTY.js
			session()->flash('rate_success', true);
		}

//		return redirect()->action('OrderController@isRate');
	}
}
