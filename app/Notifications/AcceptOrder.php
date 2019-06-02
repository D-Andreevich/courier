<?php

namespace App\Notifications;

use App\Http\ModelsORM\User;
use Illuminate\Bus\Queueable;
use App\Http\ModelsORM\Order;
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
    	$courier = User::whereId($this->order->courier_id)->first();
        $avatarSrc = $courier->avatar ?: '/img/default-avatar.svg';
        $avatar = "<img class=\"avatarInfo\" src=\"{$avatarSrc}\" alt=\"avatar\">";    	
        return [
	        'data' => $avatar . 'Курьер ' . $courier->name . ' принял Ваш заказ №' . $this->order->id,
        ];
    }
}
