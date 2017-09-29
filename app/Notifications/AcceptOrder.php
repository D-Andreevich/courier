<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use App\Order;
use Illuminate\Notifications\Notification;

class AcceptOrder extends Notification
{
    use Queueable;
    
    protected $order;
	
	/**
	 * Create a new notification instance.
	 *
	 * @param $order
	 */
    public function __construct(Order $order)
    {
    	$this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['database'];
    }
	
    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
    	$courier = User::find($this->order->courier_id)->name;
    	
        return [
	        'data' => $courier . ' принял Ваш заказ #' . $this->order->id,
        ];
    }
}
