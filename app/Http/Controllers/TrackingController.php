<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function trackingMap()
    {
        return view('track/tracking');
    }

    public function getPosition(){
        $order_id = ''; //придумать как записывать нужную поссылку
        // ОБРАТИТЬСЯ В БД И ВЫВЕСТИ КООРДИНАТЫ
        $query = "SELECT Y(`current_position`) AS lat, X(`current_position`) AS lng
					FROM `orders` WHERE `id` = {$order_id} ;";
        $orders = DB::select($query);
    }

    public function positionGoToBD()
    {
        $user = User::find(auth()->user()->id);

        $pos1 = $_POST['lat'];
        $pos2 = $_POST['lng'];

        DB::table('orders')
            ->where('courier_id', $user)
            ->update(['current_position' => PointFromText('POINT('.$pos1.' '.$pos2.')') ]);


        echo json_encode(['data' => 'запрос-ответ ok']);
    }
}
