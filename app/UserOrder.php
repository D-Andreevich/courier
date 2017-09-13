<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserOrder extends Model
{
	protected $table = 'users_orders';
	
	protected $fillable = [
		'user_id',
		'order_id'
	];
	
}


