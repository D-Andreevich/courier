<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CabinetCourierController extends Controller
{
	/**
	 *  Show auth user accepted orders and client info
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$result = [];
		$users = User::all();
		foreach($users as $user) {
			foreach($user->orders()->where('courier_id', '=', auth()->user()->id)->orderBy('updated_at', 'desc')->get() as $order) {
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
		
		return view('cabinet.courier', ['entries' => $entries]);
	}
}
