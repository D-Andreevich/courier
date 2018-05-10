<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class OrderDelivered extends Controller
{
    public function __invoke($token)
    {
        $orderModel = Order::all()->where('status', 'taken')->where('delivered_token', $token);

        if (!$orderModel->isEmpty()) {

            // Set QR code size
            QrCode::size(250);

            return view('orders.confirm', ['token' => $token]);
        } else {
            // Create a flash session for NOTY.js
            session()->flash('empty_receive_token', true);

            return redirect()->route('home');
        }
    }
}
