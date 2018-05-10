<?php

namespace App\Http\Controllers\Order;

use App\Events\NewNotificationAdded;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Notification\NotificationGet;
use App\Notifications\AcceptOrder;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderAccept extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order->status === 'published') {
            $order->courier_id = $request->courier_id;
            $order->status = 'accepted';
            $order->taken_token = md5($request->user_id . $request->order_id . $request->courier_id);

            if ($order->save()) {
                $client = User::find($request->user_id);
                //$courier = User::find($request->courier_id)->name;
                //$phone = preg_replace('/[^0-9]/', '', $client->phone);


                // Send SMS
//			Nexmo::message()->send([
//				'type' => 'unicode',
//				'to' => $phone,
//				'from' => 'Courier+',
//				'text' => $courier . ' принял Ваш заказ №' . $request->order_id,
//			]);

                // Create a flash session for NOTY.js
                session()->flash('accepted_order', true);

                // Create notification for database
                Notification::send($client, new AcceptOrder($order));
                event(
                    new NewNotificationAdded($client->unreadNotifications)
                );
            }
        } else {
            // Create a flash session for NOTY.js
            session()->flash('order_had_accept', true);

            return route('home');
        }
    }
}
