<?php

namespace App\Http\Controllers;

use App\Events\NewEventOnMap;
use App\Events\NewNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mockery\Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $config,$smsObj;
    public function __construct()
    {
        $this->config = config('sms');
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
