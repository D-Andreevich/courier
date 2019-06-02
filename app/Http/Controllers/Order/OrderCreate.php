<?php

namespace App\Http\Controllers\Order;

use App\Events\NewOrderOnMap;
use App\Http\Controllers\Controller;
use App\Http\ModelsORM\User;
use App\Http\Requests\OrderCreateRequest as Request;
use App\Http\ModelsORM\Order;
use Illuminate\Support\Facades\Route;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Intervention\Image\Facades\Image;

class OrderCreate extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        $user = User::whereId(auth()->user()->id)->first();
        $data['time_of_receipt'] = date("Y-m-d H:i:s");
        $pointA = explode(', ', $data['coordinate_a']);
        $pointB = explode(', ', $data['coordinate_b']);

        // Get city name for this order
        $order = new Order([
            'user_id' => Auth()->id(),
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
            new NewOrderOnMap($order)
        );
        return redirect()->route('home');
    }

}
