<?php
/**
 * Created by PhpStorm.
 * User: d-andreevich
 * Date: 21.03.18
 * Time: 12:16
 */
return array(
    "driver" => "smtp",
    "host" => "smtp.mailtrap.io",
    "port" => 2525,
    "from" => array(
        "address" => "from@example.com",
        "name" => "Example"
    ),
    "username" => "dc950f5a57a3d5",
    "password" => "480e856861d23f",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "pretend" => false
);