<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
	public function profile()
	{
		return view('profile', array('user' => auth()->user()));
	}
	
	public function updateAvatar(Request $request)
	{
		// Handle the user upload of avatar
		if ($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename));
			$user = auth()->user();
			$user->avatar = $filename;
			$user->save();
		}
		
		return view('profile', array('user' => auth()->user()));
		
	}
	
	public function updateRating(Request $request)
	{
		
		$user = User::find($request->courierId);
		$user->total_rating += $request->rating;
		$user->total_rates += $request->userCount;
		$user->rating = $user->total_rating / $user->total_rates;
		$user->save();
	}
}
