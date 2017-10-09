<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function index()
	{
		 if (auth()->user()) {
		 	
			 return auth()->user()->unreadNotifications;
		 }
	}
}
