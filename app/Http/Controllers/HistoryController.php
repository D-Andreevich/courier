<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
    	$userId = Auth::user()->id;
        $user = User::find($userId);
        $orders = $user->orders;
	    
        return view('history', ['orders' => $orders]);
    }
}
