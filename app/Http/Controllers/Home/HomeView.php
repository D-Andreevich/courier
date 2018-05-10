<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class HomeView extends Controller
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('home');
    }
}
