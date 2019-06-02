<?php

namespace App\Http\Controllers\Order;

use App\Events\NewOrderOnMap;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Notifications\DeliveredOrder;
use App\Http\ModelsORM\Order;
use App\Http\ModelsORM\User;
use Illuminate\Support\Facades\Notification;

class OrderConfirmed extends Controller
{
    public function __invoke($token)
    {
        $orderModel = Order::all()->where('status', 'taken')->where('delivered_token', $token);

        if (!$orderModel->isEmpty()) {

            if (auth()->user()) {

                foreach ($orderModel as $order) {

                    if (auth()->user()->id === $order->courier_id) {

                        $order->status = 'completed';

                        if ($order->save()) {

                            $clientId = substr($token, -1);
                            $client = User::whereId($clientId)->first();
                            $courier = User::whereId($order->courier_id)->first();
                            $phone = preg_replace('/[^0-9]/', '', $client->phone);

                            // Create notification for database
                            Notification::send($client, new DeliveredOrder($order));

                            $orders = Order::all('id', 'courier_id', 'status')->where('courier_id', $order->courier_id)->where('status', 'taken');

                            if ($orders->isEmpty()) {
                                $courier->is_tracking = false;
                                $courier->save();
                            }

                            // Send SMS
                            $result = $this->sendSMS($phone, 'Курьер ' . $courier->name . ' доставил Ваш заказ №' . $order->id . '. Оценить курьера Вы можете в своем кабинете');

//							Nexmo::message()->send([
//								'type' => 'unicode',
//								'to' => $phone,
//								'from' => 'Courier+',
//								'text' => 'Курьер ' . $courier->name . ' доставил Ваш заказ №' . $order->id . '. Оценить курьера Вы можете в своем кабинете'
//							]);

                            // Create a flash session for NOTY.js
                            session()->flash('deliveredSuccess', true);
                            event(
                                new NewNotification($client->id, $client->unreadNotifications)
                            );
                            return redirect()->route('courier_complete');
                        }
                    } else {

                        // Create a flash session for NOTY.js
                        session()->flash('not_this_courier', true);

                        return redirect()->route('home');
                    }
                }
            } else {

                // Create a flash session for NOTY.js
                session()->flash('not_auth_courier', true);

                return redirect('/login');
            }
        } else {

            // Create a flash session for NOTY.js
            session()->flash('empty_receive_token', true);

            return redirect()->route('home');
        }
    }
}
