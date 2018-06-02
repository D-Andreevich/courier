<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;

class NotificationGet extends Controller
{
	public function __invoke()
	{
		 if (auth()->user()) {
			 return auth()->user()->unreadNotifications;
		 }
	}
}
