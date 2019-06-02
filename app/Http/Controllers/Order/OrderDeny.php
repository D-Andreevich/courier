<?php

namespace App\Http\Controllers\Order;

use App\Events\NewOrderOnMap;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Notifications\DenyOrder;
use App\Http\ModelsORM\Order;
use App\Http\ModelsORM\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderDeny extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::whereId($request->order_id)->first();
        $order->status = 'published';
        // $order->courier_id = 0;
        $order->taken_token = null;

        if ($order->save()) {

            $client = User::whereId($request->user_id)->first();
            $phone = preg_replace('/[^0-9]/', '', $client->phone);

            // Create notification for database

            Notification::send($client, new DenyOrder($order));
            // Send SMS
//			Nexmo::message()->send([
//				'type' => 'unicode',
//				'to'   => $phone,
//				'from' => 'Courier+',
//				'text' => 'Курьер отменил Ваш заказ №' . $request->order_id,
//			]);

            // Create a flash session for NOTY.js
            session()->flash('deny_order', true);
        }
        event(
            new NewNotification($client->id, $client->unreadNotifications)
        );
        event(
            new NewOrderOnMap($order)
        );
    }
}
