<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class QrCodeController extends Controller
{
	public function index()
	{
		QrCode::size(250);
		
		$result = [];
		$authUserId = Auth::user()->id;
		$orders = Order::with('users', 'usersOrders')->get(['id', 'time_of_receipt', 'coordinate_a', 'coordinate_b', 'address_a', 'address_b']);
		foreach ($orders as $order) {
			$clients = $order->usersOrders->where('role', 'courier')->where('user_id', $authUserId);
			foreach ($clients as $client) {
				if ($client->user_id === $authUserId && $client->role === 'courier') {
					$result[] = [$order->id, $order->time_of_receipt, $order->coordinate_a, $order->coordinate_b, $order->address_a, $order->address_b];
				}
			}
		}
		return view('qrcodes', ['qrcodes' => $result]);
	}
}
