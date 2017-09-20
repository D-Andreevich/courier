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
			
			$clientId = Order::find($orderId)->user_id;
			$client = User::find($clientId);
			$courier = User::find($acceptedOrder->user_id);
			
			$order = new Order();
			$orderFind = $order->find($orderId);
			$orderFind->taken_token = md5($clientId) . md5($orderId) . md5($userId);
			$orderFind->save();
			
			if ($acceptedOrder->save()) {
				Notification::send($client, new AcceptOrder($acceptedOrder));
				$data = $courier->name . ' принял Ваш заказ #' . $acceptedOrder->order_id;
				StreamLabFacades::pushMessage('test' , 'AcceptOrder' , $data);
			}
			
			return redirect('/');
			//return redirect('/cabinet/courier');
		}
	}
}
