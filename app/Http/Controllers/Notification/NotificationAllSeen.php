<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;

class NotificationAllSeen extends Controller
{
    public function __invoke()
    {
        foreach (auth()->user()->notifications as $note) {
            $note->markAsRead();
        }
    }
}
