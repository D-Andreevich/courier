<?php

return [
    'status' => env('SMS_STATUS', 0),
    'class' => env('SMS_CLASS', ''),
    'caption' => env('SMS_CAPTION', 'Kurier+'),
    'apiKey' => env('SMS_API_KEY', null),
    'login' => env('SMS_LOGIN', null),
    'password' => env('SMS_PASSWORD', null),
    'emulation' => env('SMS_EMULATION', false),
];