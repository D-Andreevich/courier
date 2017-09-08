<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcceptedOrder extends Model
{
	//protected $table = 'accepted_orders';
	
    protected $fillable = [
    	'courier_id',
	    'order_id'
    ];
}
