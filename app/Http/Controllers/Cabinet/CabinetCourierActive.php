<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\ModelsORM\User;
use Illuminate\Pagination\LengthAwarePaginator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CabinetCourierActive extends Controller
{
	/**
	 *  Show auth user accepted active orders and client info
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function __invoke()
	{
		$result = [];
		$users = User::all();
		foreach($users as $user) {
			foreach($user->orders()->where('courier_id', '=', auth()->user()->id)->whereIn('status', ['accepted', 'taken'])->orderBy('updated_at', 'desc')->get() as $order) {
				$order->time_of_receipt = date("m-d-y H:i:s");
				$result[] = [$order, $user];
			};
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
		
		return view('cabinet.courier.active', ['entries' => $entries]);
	}
}
