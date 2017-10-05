<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
	/**
	 * Show users profile
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function profile()
	{
		return view('profile', array('user' => auth()->user()));
	}
	
	/**
	 * Update users avatar
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateAvatar(Request $request)
	{
		// Handle the user upload of avatar
		if ($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			$path = public_path('/uploads/avatars/' . $filename);
			
			Image::make($avatar)->resize(300, 300)->save($path);
			$user = auth()->user();
			$user->avatar = '/uploads/avatars/' . $filename;
			$user->save();
		}
		
		return view('profile', array('user' => auth()->user()));
		
	}
	
	/**
	 *  Update rating for courier
	 *
	 * @param Request $request
	 */
	public function updateRating(Request $request)
	{
		// Destroy courier_id session
		session()->forget('courier_id');
		
		$user = User::find($request->courierId);
		$user->total_rating += $request->rating;
		$user->total_rates += $request->userCount;
		$user->rating = $user->total_rating / $user->total_rates;
		$user->save();
	}
}
