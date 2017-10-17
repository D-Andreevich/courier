<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class TrackingController extends Controller
{
    public function trackingMap($id, $token)
    {
//    	$order = Order::find($id);
//
//    	$courier = null;
//
//    	if ($order->status === 'taken') {
//    		//$courier = User::find($order->courier_id);
//    		//$courier = $this->getPosition($id);
//	    } else {
//    		return redirect()->back();
//	    }
	    
        return view('track/tracking');
    }

    public function getPosition() {
	    //придумать как записывать нужную поссылку
        // ОБРАТИТЬСЯ В БД И ВЫВЕСТИ КООРДИНАТЫ
        $query = "SELECT Y(`current_position`) AS lat, X(`current_position`) AS lng
					FROM `orders` WHERE `id` = {$_GET['order_id']}";
        $orders = DB::select($query);
        
        return json_encode($orders);
    }

    public function positionGoToDB(Request $request)
    {
    	
        $courier = User::find(auth()->user()->id)->id;
	    
        $pos1 = $request->data['lat'];
        $pos2 = $request->data['lng'];
	    
        $orders = Order::all('id', 'courier_id', 'current_position', 'status')->where('courier_id', '=',$courier)->where('status', '=', 'taken');
	    
        if ($orders->isNotEmpty()) {
	        foreach ($orders as $order) {
		        //$order->current_position = PointFromText('POINT(' . $pos1 . ' ' . $pos2 . ')');
		        $order->current_position = new Point($pos1, $pos2);
		        $order->save();
	        }
        } else {
        	return 'Not find orders';
        }
	    
        //return json_encode(['data' => 'запрос-ответ ok']);
    }
}
