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
    	$order = Order::find($id);

    	if ($order->status === 'taken') {
		    return view('track/tracking');
	    } else {
    		return redirect('https://express.courier.php.a-level.com.ua');
	    }
    }

    public function getPosition(Request $request) {
        $data = $request->all();
	    //придумать как записывать нужную поссылку
        // ОБРАТИТЬСЯ В БД И ВЫВЕСТИ КООРДИНАТЫ
        $query = "SELECT Y(`current_position`) AS lat, X(`current_position`) AS lng
					FROM `orders` WHERE `id` = {$data['order_id']} /*AND `status` = 'taken'*/";
        $orders = DB::select($query);
        
        return json_encode($orders);
    }

    public function positionGoToDB(Request $request)
    {
        if(auth()->user()) {
            $courier = User::find(auth()->user()->id);
            $tracking = $courier->is_tracking;
        }else
        {
            return '0';
        }

        $pos1 = $request->data['lat'];
        $pos2 = $request->data['lng'];
	    
        $orders = Order::all('id', 'courier_id', 'current_position', 'status')->where('courier_id', '=',$courier->id)->where('status', '=', 'taken');
	    
        if ($orders->isNotEmpty()) {
	        foreach ($orders as $order) {
		        //$order->current_position = PointFromText('POINT(' . $pos1 . ' ' . $pos2 . ')');
		        $order->current_position = new Point($pos1, $pos2);
		        $order->save();
	        }
        }

        return $tracking;
    }
}
