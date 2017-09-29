<?php

namespace App\Http\Controllers;

use App\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Pagination\LengthAwarePaginator;


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
		
		$orders = auth()->user()->orders()->orderBy('updated_at', 'desc')->get();
		foreach ($orders as $order) {
			if ($order->courier_id) {
				$courier = User::find($order->courier_id);
				$result[] = [$order, $courier];
			}
		}
		
		// Create collection for pagination
		$result = collect($result);
		foreach ($result as &$values) {
			$values = collect($values);
		}
		
		// Create pagination
		$currentPage = LengthAwarePaginator::resolveCurrentPage();
		$perPage = 5;
		$currentPageSearchResults = $result->slice(($currentPage - 1) * $perPage, $perPage)->all();
		$entries = new LengthAwarePaginator($currentPageSearchResults, count($result), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);
		
		// Set QR code size
		QrCode::size(250);
		
		return view('cabinet.client', ['entries' => $entries]);
	}
}
