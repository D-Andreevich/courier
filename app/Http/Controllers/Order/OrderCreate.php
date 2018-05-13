<?php

namespace App\Http\Controllers\Order;

use App\Events\NewEventOnMap;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmOrder;
use App\Notifications\AcceptOrder;
use App\Notifications\DeliveredOrder;
use App\Notifications\DenyOrder;
use App\Notifications\TakenOrder;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Mockery\Exception;
use Nexmo\Laravel\Facade\Nexmo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class OrderCreate extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $data = $request->all();
        $data['time_of_receipt'] = date("Y-m-d H:i:s");
        $pointA = explode(', ', $data['coordinate_a']);
        $pointB = explode(', ', $data['coordinate_b']);

        // Get city name for this order
        $order = new Order([
            'user_id' => auth()->user()->id,
            'quantity' => $data['quantity'],
            'width' => $data['width'],
            'height' => $data['height'],
            'depth' => $data['depth'],
            'weight' => $data['weight'],
            'time_of_receipt' => $data['time_of_receipt'],
            'description' => $data['description'],
            'distance' => $data['distance'],
            'name_receiver' => $data['name_receiver'],
            'phone_receiver' => $data['phone_receiver'],
            'email_receiver' => $data['email_receiver'],
            'address_a' => $data['address_a'],
            'address_b' => $data['address_b'],
            'price' => $data['price'],
            'coordinate_a' => new Point(trim($pointA[0], "("), trim($pointA[1], ")")),
            'coordinate_b' => new Point(trim($pointB[0], "("), trim($pointB[1], ")")),
            'status' => 'published'
        ]);
        // Save order with pivot table
        $user->orders()->save($order);


        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = public_path("/uploads/ordersPhoto/{$order->id}/" . $filename);
            if (!file_exists(public_path("/uploads/ordersPhoto/{$order->id}/"))) {
                mkdir(public_path("/uploads/ordersPhoto/{$order->id}/"), 0777, true);
            }
            Image::make($photo)->save($path);
            $order->photo = "/uploads/ordersPhoto/{$order->id}/" . $filename;
            //        $user->orders()->save($order);
            $order->save();
        }

        // Create a flash session for NOTY.js
        $request->session()->flash('previous-route', Route::current()->getName());
        event(
            new NewEventOnMap()
        );
        return redirect()->route('home');
    }

}
