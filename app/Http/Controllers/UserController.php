<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateRating(Request $request) {
    	
    	$user = User::find($request->courierId);
    	$user->total_rating += $request->rating;
    	$user->total_rates += $request->userCount;
    	$user->rating = $user->total_rating /  $user->total_rates;
    	$user->save();
    }
}
