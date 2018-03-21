<?php

namespace App\Events\Hidden;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SendSms // implements ShouldBroadcast
{
    use Dispatchable, SerializesModels; // , InteractsWithSockets

    public $response;
    public $data;
    public $type = 'send';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $response, array $data)
    {
        $this->response = $response;
        $this->data = $data;
    }
}
