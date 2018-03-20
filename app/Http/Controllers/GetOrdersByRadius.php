<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class getOrdersByRadius extends Controller
{
    public function postOrdersByR(Request $request)
    {
        $data = $request->all();
        if (isset($data['radius'])) {
            header("Content-type: text/txt; charset=UTF-8");
            if ($data['radius'] != 'null') {

                $query = "SELECT `id`, `user_id`, `status`, `address_a`, `distance`, `weight`, `width`, `height`, `depth`, `price`, `time_of_receipt`, ST_Y(`coordinate_a`) AS lat, ST_X(`coordinate_a`) AS lng,
                    ((ACOS(SIN({$data['lat']} * PI() / 180) * SIN(ST_Y(`coordinate_a`) * PI() / 180) + 
					COS({$data['lat']} * PI() / 180) * COS(ST_Y(`coordinate_a`) * PI() / 180) * 
					COS(({$data['lng']} - ST_X(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance_r`
					FROM `orders`  HAVING `distance_r`<= {$data['radius']} AND `status` = 'published'";
                $orders = DB::select($query);
                echo json_encode($orders);
            } else {
                echo 'карявый POST запрос';
            }
        }
    }

    /*$query = "SELECT `id`, `address_a`, `distance`, `weight`, `width`, `height`, `depth`, `price`, `time_of_receipt`, X(`coordinate_a`) AS lat, Y(`coordinate_a`) AS lng,
                        ((ACOS(SIN({$_GET['lat']} * PI() / 180) * SIN(X(`coordinate_a`) * PI() / 180) +
                        COS({$_GET['lat']} * PI() / 180) * COS(X(`coordinate_a`) * PI() / 180) *
                        COS(({$_GET['lng']} - Y(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance_r`
                        FROM `orders` HAVING `distance_r`<= {$_GET['radius']}";*/

    public function getOrdersByR(Request $request)
    {
        $data = $request->all();
        if (isset($data['radius'])) {
            header("ContentType: application/json; charset=utf-8");
            if ($data['radius'] != 'null') {
                $query = "SELECT `id`, `user_id`, `status`, `address_a`, `distance`, `weight`, `width`, `height`, `depth`, `price`, `time_of_receipt`, Y(`coordinate_a`) AS lat, X(`coordinate_a`) AS lng,
                    ((ACOS(SIN({$data['lat']} * PI() / 180) * SIN(Y(`coordinate_a`) * PI() / 180) + 
					COS({$data['lat']} * PI() / 180) * COS(Y(`coordinate_a`) * PI() / 180) * 
					COS(({$data['lng']} - X(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance_r`
					FROM `orders`  HAVING `distance_r`<= {$data['radius']} AND `status` = 'published'";
                $orders = DB::select($query);

                echo json_encode($orders);
            } else {
                echo 'карявый GET запрос';
            }
        }
    }
}

