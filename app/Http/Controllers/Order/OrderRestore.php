<?php

namespace App\Http\Controllers\Order;

use App\Events\NewEventOnMap;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderRestore extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 'published';

        if ($order->save()) {

            // Create a flash session for NOTY.js
            session()->flash('restore_order', true);
        }

        event(
            new NewEventOnMap()
        );
    }
}
