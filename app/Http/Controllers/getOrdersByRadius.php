<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class getOrdersByRadius extends Controller
{
    public function postOrdersByR()
    {
        if(isset($_POST['radius'])) {
            header("Content-type: text/txt; charset=UTF-8");
            if($_POST['radius']!= 'null') {

                $query = "SELECT `*`, X(`coordinate_a`), Y(`coordinate_a`),
					((ACOS(SIN({$_POST['lat']} * PI() / 180) * SIN(X(`coordinates`) * PI() / 180) + 
					COS({$_POST['lat']} * PI() / 180) * COS(X(`coordinate_a`) * PI() / 180) * 
					COS(({$_POST['lng']} - Y(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance`
					FROM `orders` HAVING `distance`<= {$_POST['radius']} ;";
                $orders =  DB::select($query);
                echo json_encode($orders);
            }
            else {
                echo 'карявый POST запрос';
            }
        }
        $km = 1000;

        // If user table is not empty
        /*if (User::all()->count()) {
            $users = User::all('id');
            foreach ($users as $user) {

                $orders = $user->orders()->where('status', 'published')->get();

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
        }*/
    }

/*$query = "SELECT `id`, `address_a`, `distance`, `weight`, `width`, `height`, `depth`, `price`, `time_of_receipt`, X(`coordinate_a`) AS lat, Y(`coordinate_a`) AS lng,
                    ((ACOS(SIN({$_GET['lat']} * PI() / 180) * SIN(X(`coordinate_a`) * PI() / 180) +
					COS({$_GET['lat']} * PI() / 180) * COS(X(`coordinate_a`) * PI() / 180) *
					COS(({$_GET['lng']} - Y(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance_r`
					FROM `orders` HAVING `distance_r`<= {$_GET['radius']}";*/

    public function getOrdersByR()
    {
        if(isset($_GET['radius'])) {
            header("Content-type: text/txt; charset=UTF-8");
            if($_GET['radius']!= 'null') {
                $query = "SELECT `id`, `address_a`, `distance`, `weight`, `width`, `height`, `depth`, `price`, `time_of_receipt`, Y(`coordinate_a`) AS lat, X(`coordinate_a`) AS lng,
                    ((ACOS(SIN({$_GET['lat']} * PI() / 180) * SIN(Y(`coordinate_a`) * PI() / 180) + 
					COS({$_GET['lat']} * PI() / 180) * COS(Y(`coordinate_a`) * PI() / 180) * 
					COS(({$_GET['lng']} - X(`coordinate_a`)) * PI() / 180)) * 180 / PI()) *  60 * 1.1515 * 1.609344) AS `distance_r`
					FROM `orders` HAVING `distance_r`<= {$_GET['radius']}";
                $orders =  DB::select($query);
                echo json_encode($orders);
            }
            else {
                echo 'карявый GET запрос';
            }
        }
    }
}
