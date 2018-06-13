<?php

namespace App\Http\Controllers\Order;

use App\Events\DeleteOrderOnMap;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderRemove extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::whereId($request->order_id)->first();

        if ($order->status === 'published') {
            $order->status = 'removedByClient';
            $order->save();
            // Create a flash session for NOTY.js
            session()->flash('remove_order', true);
        } else {

            // Create a flash session for NOTY.js
            session()->flash('deny_remove_order', true);
        }

        event(
            new DeleteOrderOnMap($order->id)
        );
    }
}
