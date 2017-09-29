<?php

namespace App\Http\Controllers;

use App\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CabinetClientController extends Controller
{
	/**
	 *  Show auth user orders with courier info
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$result = [];
		$orders = auth()->user()->orders()->paginate(15)->sortByDesc('updated_at');
		
		foreach ($orders as $order) {
			if ($order->courier_id) {
				$courier = User::find($order->courier_id);
				$result[] = [$order, $courier];
			}
		}
		
		// Set QR code size
		QrCode::size(250);
		
		return view('cabinet.client', ['result' => $result]);
	}
}
