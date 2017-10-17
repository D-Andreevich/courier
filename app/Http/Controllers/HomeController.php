<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
	}
	
	/**
	 * Create markers for google map
	 */
	public function sendMarker()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
		$km = 1000;
		
		// If user table is not empty
		if (User::all()->count()) {
			$users = User::all('id');
			foreach ($users as $user) {
					
				// Check your city
				if ($query && $query['status'] === 'success') {
					$orders = $user->orders()->where('status', 'published')->where('region', $query['city'])->get();
				} else {
					$orders = $user->orders()->where('status', 'published')->get();
				}
				
				// Start XML file, echo parent node
				echo '<markers>';
				
				// Iterate through the rows, printing XML nodes for each
				foreach ($orders as $order) {
					$lat = $order->coordinate_a->getLat();    // 40.7484404
					$lng = $order->coordinate_a->getLng();    // -73.9878441
					
					// Add to XML document node
					echo '<marker ';
					echo 'order_id="' . $order->id . '" ';
					echo 'user_id="' . $user->id . '" ';
					echo 'address="' . $order->address_a . '" ';
					echo 'lat="' . $lat . '" ';
					echo 'lng="' . $lng . '" ';
					echo 'distance="' . ($order->distance / $km) . ' км' . '" ';
					echo 'weight="' . $order->weight . '" ';
					echo 'width="' . $order->width . '" ';
					echo 'height="' . $order->height . '" ';
					echo 'depth="' . $order->depth . '" ';
					echo 'price="' . $order->price . '" ';
					echo 'time_of_receipt="' . $order->time_of_receipt . '" ';
					echo '/>';
				}
				
				// End XML file
				echo '</markers>';
			}
		}
	}
	

	/**
	 * Show the homepage.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('home');
	}
}
