<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\UserOrder;
use Illuminate\Support\Facades\Auth;

class CabinetCourierController extends Controller
{
	public function index()
	{
		$result = [];
		$authUserId = Auth::user()->id;
		$orders = Order::with('users', 'usersOrders')->get();

		foreach ($orders as $order) {
			$clients = $order->usersOrders->where('role', 'courier')->where('user_id', $authUserId);
			foreach ($clients as $client) {
				if ($client->user_id === $authUserId && $client->role === 'courier') {
					foreach ($order->users as $user) {
						if ($user->id !== $authUserId) {
							$result[] = [$order, $user];
						}
					}
				}
			}
		}
		
		return view('cabinet.courier', ['result' => $result]);
	}
}
