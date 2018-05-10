<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;

class OrderAllSeen extends Controller
{
    public function __invoke()
    {
        foreach (auth()->user()->notifications as $note) {
            $note->markAsRead();
        }
    }
}
