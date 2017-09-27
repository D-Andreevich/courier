<?php

namespace App\Http\Controllers;

use App\User;

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
			foreach($user->orders()->where('courier_id', '=', auth()->user()->id)->paginate(5)->sortByDesc('updated_at') as $order) {
				$result[] = [$order, $user];
			};
		}
		
		return view('cabinet.courier', ['result' => $result]);
	}
}
