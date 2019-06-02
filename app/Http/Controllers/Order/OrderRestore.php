<?php

namespace App\Http\Controllers\Order;

use App\Events\NewOrderOnMap;
use App\Http\Controllers\Controller;
use App\Http\ModelsORM\Order;
use Illuminate\Http\Request;

class OrderRestore extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::whereId($request->order_id)->first();
        $order->status = 'published';

        if ($order->save()) {

            // Create a flash session for NOTY.js
            session()->flash('restore_order', true);
        }

        event(
            new NewOrderOnMap($order)
        );
    }
}
