<?php

namespace App\Http\Controllers\Order;

use App\Events\NewNotificationAdded;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmOrder;
use App\Notifications\TakenOrder;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class OrderTaken extends Controller
{
    public function __invoke($id, $token)
    {
        $orderModel = Order::where('taken_token', $token)->where('status', 'accepted')->get();

        if ($orderModel->isEmpty()) {

            // Create a flash session for NOTY.js
            session()->flash('empty_taken_token', true);

            return redirect()->route('home');
        }

        if (auth()->user()) {

            foreach ($orderModel as $order) {
                if (auth()->user()->id == $order->courier_id) {
                    $order->status = 'taken';
                    $order->delivered_token = md5($order->taken_token) . $id;

                    if ($order->save()) {

                        $client = User::find($id);
                        $courier = User::find($order->courier_id);
                        //$phone = preg_replace('/[^0-9]/', '', $client->phone);
                        $receiverPhone = preg_replace('/[^0-9]/', '', $order->phone_receiver);
                        $_text = "Код для подтвеждения доставки " . url('order/delivered/' . $order->delivered_token);
                        $courier->is_tracking = true;
                        $courier->save();

                        // Create notification for database
                        Notification::send($client, new TakenOrder($order));
                        event(
                            new NewNotificationAdded($client->unreadNotifications)
                        );
                        // Send SMS
                        $result = $this->sendSMS($receiverPhone, $_text);

//						Nexmo::message()->send([
//							'type' => 'unicode',
//							'to' => $phone,
//							'from' => 'Courier+',
//							'text' => 'Курьер ' . $courier->name . ' забрал Ваш заказ №' . $order->id
//						]);

                        // Send SMS to receiver
//                        Nexmo::message()->send([
//                            'type' => 'unicode',
//                            'to' => $receiverPhone,
//                            'from' => 'NEXMO',
//                            'text' => url('order/delivered/' . $order->delivered_token)
//                        ]);
                        // Send email to receiver
                        Mail::to($order->email_receiver)->send(new ConfirmOrder($order));

                        // Create a flash session for NOTY.js
                        session()->flash('taken_order', true);
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

        return redirect()->route('client_active');
    }
}
