<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserOrder;
use App\Order;
use App\Notifications\AcceptOrder;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;
use Illuminate\Support\Facades\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

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
			
			if ($acceptedOrder->save()) {
				$clientId = Order::find($orderId)->user_id;
				$client = User::find($clientId);
				$courier = User::find($acceptedOrder->user_id);
				
				Notification::send($client, new AcceptOrder($acceptedOrder));
				$data = $courier->name . ' принял Ваш заказ #' . $acceptedOrder->order_id;
				StreamLabFacades::pushMessage('test' , 'AcceptOrder' , $data);
				
			}
			
			return response()->json($acceptedOrder);
			//return redirect('/cabinet/courier');
		}
	}
}
