<?php

namespace App\Http\Controllers;

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

class OrderController extends Controller
{
    protected $config,$smsObj;

    public function __construct()
    {
        $this->config = config('sms');
    }

    /**
     * Show add order page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('orders.add');
    }

    /**
     * Create order for Auth user
     *
     * @param Request $request *
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function create(Request $request)
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

        return redirect()->route('home');
    }

    /**
     * Courier accepted the order
     *
     * @param Request $request
     */
    public function accept(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order->status === 'published') {
            $order->courier_id = $request->courier_id;
            $order->status = 'accepted';
            $order->taken_token = md5($request->user_id . $request->order_id . $request->courier_id);

            if ($order->save()) {
                $client = User::find($request->user_id);
                //$courier = User::find($request->courier_id)->name;
                //$phone = preg_replace('/[^0-9]/', '', $client->phone);


                // Send SMS
//			Nexmo::message()->send([
//				'type' => 'unicode',
//				'to' => $phone,
//				'from' => 'Courier+',
//				'text' => $courier . ' принял Ваш заказ №' . $request->order_id,
//			]);

                // Create a flash session for NOTY.js
                session()->flash('accepted_order', true);

                // Create notification for database
                Notification::send($client, new AcceptOrder($order));

            }
        } else {

            // Create a flash session for NOTY.js
            session()->flash('order_had_accept', true);

            return route('home');
        }
    }

    /**
     * Confirm order using the taken_token
     *
     * @param $id
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function taken($id, $token)
    {
        $orderModel = Order::where('taken_token', $token)->where('status', 'accepted')->get();

        if ($orderModel->isEmpty()) {

            // Create a flash session for NOTY.js
            session()->flash('empty_taken_token', true);

            return redirect()->route('home');
        }

        if (auth()->user()) {

            foreach ($orderModel as $order) {
                if (auth()->user()->id == $order->courier_id) {
                    $order->status = 'taken';
                    $order->delivered_token = md5($order->taken_token) . $id;

                    if ($order->save()) {

                        $client = User::find($id);
                        $courier = User::find($order->courier_id);
                        //$phone = preg_replace('/[^0-9]/', '', $client->phone);
                        $receiverPhone = preg_replace('/[^0-9]/', '', $order->phone_receiver);
                        $_text = "Код для подтвеждения доставки " . url('order/delivered/' . $order->delivered_token);
                        $courier->is_tracking = true;
                        $courier->save();

                        // Create notification for database
                        Notification::send($client, new TakenOrder($order));

                        // Send SMS
                        $result = $this->sendSMS($receiverPhone, $_text);
                        
//						Nexmo::message()->send([
//							'type' => 'unicode',
//							'to' => $phone,
//							'from' => 'Courier+',
//							'text' => 'Курьер ' . $courier->name . ' забрал Ваш заказ №' . $order->id
//						]);

                        // Send SMS to receiver
//                        Nexmo::message()->send([
//                            'type' => 'unicode',
//                            'to' => $receiverPhone,
//                            'from' => 'NEXMO',
//                            'text' => url('order/delivered/' . $order->delivered_token)
//                        ]);
                        // Send email to receiver
                        Mail::to($order->email_receiver)->send(new ConfirmOrder($order));

                        // Create a flash session for NOTY.js
                        session()->flash('taken_order', true);
                    }
                } else {
                    // Create a flash session for NOTY.js
                    session()->flash('not_this_courier', true);

                    return redirect()->route('home');
                }
            }
        } else {
            // Create a flash session for NOTY.js
            session()->flash('not_auth_courier', true);

            return redirect('/login');
        }

        return redirect()->route('client_active');
    }

    /**
     *  Generate URL with QR Code
     *
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delivered($token)
    {
        $orderModel = Order::all()->where('status', 'taken')->where('delivered_token', $token);

        if (!$orderModel->isEmpty()) {

            // Set QR code size
            QrCode::size(250);

            return view('orders.confirm', ['token' => $token]);

        } else {

            // Create a flash session for NOTY.js
            session()->flash('empty_receive_token', true);

            return redirect()->route('home');
        }
    }

    /**
     * Confirm taken order by courier
     *
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmed($token)
    {
        $orderModel = Order::all()->where('status', 'taken')->where('delivered_token', $token);

        if (!$orderModel->isEmpty()) {

            if (auth()->user()) {

                foreach ($orderModel as $order) {

                    if (auth()->user()->id === $order->courier_id) {

                        $order->status = 'completed';

                        if ($order->save()) {

                            $clientId = substr($token, -1);
                            $client = User::find($clientId);
                            $courier = User::find($order->courier_id);
                            $phone = preg_replace('/[^0-9]/', '', $client->phone);

                            // Create notification for database
                            Notification::send($client, new DeliveredOrder($order));

                            $orders = Order::all('id', 'courier_id', 'status')->where('courier_id', $order->courier_id)->where('status', 'taken');

                            if ($orders->isEmpty()) {
                                $courier->is_tracking = false;
                                $courier->save();
                            }

                            // Send SMS
                            $result = $this->sendSMS($phone, 'Курьер ' . $courier->name . ' доставил Ваш заказ №' . $order->id . '. Оценить курьера Вы можете в своем кабинете');

//							Nexmo::message()->send([
//								'type' => 'unicode',
//								'to' => $phone,
//								'from' => 'Courier+',
//								'text' => 'Курьер ' . $courier->name . ' доставил Ваш заказ №' . $order->id . '. Оценить курьера Вы можете в своем кабинете'
//							]);

                            // Create a flash session for NOTY.js
                            session()->flash('deliveredSuccess', true);

                            return redirect()->route('courier_complete');
                        }
                    } else {

                        // Create a flash session for NOTY.js
                        session()->flash('not_this_courier', true);

                        return redirect()->route('home');
                    }
                }
            } else {

                // Create a flash session for NOTY.js
                session()->flash('not_auth_courier', true);

                return redirect('/login');
            }
        } else {

            // Create a flash session for NOTY.js
            session()->flash('empty_receive_token', true);

            return redirect()->route('home');
        }
    }

    /**
     * Deny the order by courier
     *
     * @param Request $request
     */
    public function deny(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 'published';
        // $order->courier_id = 0;
        $order->taken_token = null;

        if ($order->save()) {

            $client = User::find($request->user_id);
            $phone = preg_replace('/[^0-9]/', '', $client->phone);

            // Create notification for database
            Notification::send($client, new DenyOrder($order));

            // Send SMS
//			Nexmo::message()->send([
//				'type' => 'unicode',
//				'to'   => $phone,
//				'from' => 'Courier+',
//				'text' => 'Курьер отменил Ваш заказ №' . $request->order_id,
//			]);

            // Create a flash session for NOTY.js
            session()->flash('deny_order', true);
        }
    }

    /**
     * Remove the order by client
     *
     * @param Request $request
     */
    public function remove(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order->status === 'published') {
            $order->status = 'removedByClient';
            $order->save();

            // Create a flash session for NOTY.js
            session()->flash('remove_order', true);

        } else {

            // Create a flash session for NOTY.js
            session()->flash('deny_remove_order', true);
        }
    }

    public function restore(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 'published';

        if ($order->save()) {

            // Create a flash session for NOTY.js
            session()->flash('restore_order', true);

        }
    }

    /**
     * Able to make unread notifications
     */
    public function allSeen()
    {
        foreach (auth()->user()->notifications as $note) {
            $note->markAsRead();
        }
    }

    /**
     * @param int $phone
     * @param string $massage
     * @return bool
     */
    public function sendSMS(int $phone, string $massage)
    {
        try {
            $this->smsObj = app($this->config['class']);
            return $this->smsObj->send($this->config['caption'], $phone, $massage);
        }catch (Exception $exception){
//            return $exception->getMessage();
            return false;
        }

    }
}
