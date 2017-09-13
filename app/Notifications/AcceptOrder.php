<?php

namespace App\Notifications;

use App\User;
use App\UserOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AcceptOrder extends Notification
{
    use Queueable;
	
	protected $users_orders;
	
	/**
	 * Create a new notification instance.
	 *
	 * @param UserOrder $users_orders
	 *
	 * @internal param UserOrder $user_order
	 *
	 * @internal param UserOrder $userOrder
	 */
    public function __construct(UserOrder $users_orders)
    {
        $this->users_orders = $users_orders;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }
	
    /**
     * Get the array representation of the notification.
     *
     * @param
     * @return array
     */
    public function toArray()
    {
    	$courier = User::find($this->users_orders->user_id)->name;
    	
        return [
	        'data' => $courier . ' принял Ваш заказ #' . $this->users_orders->order_id,
        ];
    }
}
