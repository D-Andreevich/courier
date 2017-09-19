<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmOrder extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
	
	/**
	 * Create a new message instance.
	 *
	 * @param Order $order
	 */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.confirmorder')->with([
        	'url' => url('delivered/' . $this->order->delivered_token)
        ]);
    }
}
