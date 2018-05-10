<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;

class OrderViewForm extends Controller
{
    public function __invoke()
    {
        return view('orders.add');
    }
}
