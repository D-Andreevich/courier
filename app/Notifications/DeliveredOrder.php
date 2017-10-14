<?php

namespace App\Notifications;

use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeliveredOrder extends Notification
{
	use Queueable;
	
	protected $order;
	
	/**
	 * Create a new notification instance.
	 *
	 * @param Order $order
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}
	
	/**
	 * Get the notification's delivery channels.
	 **
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
		$order = Order::find($this->order->id);
		$courier = User::find($order->courier_id);
		$avatar = "<img class=\"avatarInfo\" src=\"$courier->avatar\" alt=\"avatar\">";
		
		
		return [
			'data' => $avatar . 'Курьер ' . $courier->name . ' доставил Ваш заказ №' . $order->id
		];
	}
}
