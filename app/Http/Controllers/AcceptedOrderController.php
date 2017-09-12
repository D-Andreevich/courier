<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserOrder;
use App\Order;

class AcceptedOrderController extends Controller
{
	public function store(Request $request)
	{
		$orderId = $request->order_id;
		$userId = $request->user_id;
		$role = $request->role;
		
		if ($request->ajax()) {
			
			$acceptedOrder = new UserOrder();
			$acceptedOrder->user_id = $userId;
			$acceptedOrder->order_id = $orderId;
			$acceptedOrder->role = $role;
			$acceptedOrder->save();
			
			return response()->json($acceptedOrder);
			//return redirect('/cabinet/courier');
		}
	}
}
