<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CabinetClientComplete extends Controller
{
	/**
	 *  Show auth user active orders with courier info
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function __invoke()
	{
		$result = [];
		
		$orders = auth()->user()->orders()->whereIn('status', ['completed', 'removed', 'removedByClient'])->orderBy('updated_at', 'desc')->get();
		foreach ($orders as $order) {
			$courier = User::find($order->courier_id);
			$order->time_of_receipt = date("m-d-y H:i:s");
			if ($order->status === 'removedByClient') {
				$courier = null;
				$result[] = [$order, $courier];
			} else {
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
		
		return view('cabinet.client.complete', ['entries' => $entries]);
	}
}
