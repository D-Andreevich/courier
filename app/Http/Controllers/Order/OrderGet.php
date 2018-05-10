<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderGet extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $data['radius'] = $data['radius']?? 25;

        $query = "SELECT `id`, `user_id`, `status`, `address_a`, `distance`, `weight`, `width`, `height`, `depth`, `price`, `time_of_receipt`, ST_Y(`coordinate_a`) AS lat, ST_X(`coordinate_a`) AS lng,
                    ((ACOS(SIN({$data['lat']} * PI() / 180) * SIN(ST_Y(`coordinate_a`) * PI() / 180) + 
					COS({$data['lat']} * PI() / 180) * COS(ST_Y(`coordinate_a`) * PI() / 180) * 
					COS(({$data['lng']} - ST_X(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance_r`
					FROM `orders`  HAVING `distance_r`<= {$data['radius']} AND `status` = 'published'";
        $orders = \DB::select($query);

        return response()->json($orders);
    }
}
