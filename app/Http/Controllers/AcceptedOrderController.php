<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcceptedOrder;
use App\Order;

class AcceptedOrderController extends Controller
{
	public function store(Request $request)
	{
		$orderId = $request->order_id;
		$courierId = $request->courier_id;
		
		if ($request->ajax()) {
			
			$acceptedOrder = new AcceptedOrder();
			$acceptedOrder->courier_id = $courierId;
			$acceptedOrder->order_id = $orderId;
			$acceptedOrder->saveOrFail();
			
			return response()->json($acceptedOrder);
		}
	}
}
