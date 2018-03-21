<?php

namespace App\Components\Sms\Interfaces;

interface SmsHandler
{
    /**
     * @param $from string — адрес отправителя;
     * @param $to integer — номер телефона получателя сообщения;
     * @param $message string — текст сообщения;
     */
    public function send($from, $to, $message);

    /**
     * @param $smsId
     * @return string
     */
    public function receiveSMS($smsId);

    public function getResponse();

    public function getBalance();

    public function getData();

    public function hasErrors();

    public function getErrors();
}