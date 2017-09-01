<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'quantity', 'width', 'height', 'depth', 'weight', 'time_of_receipt', 'description', 'is_vehicle', 'name_receiver', 'phone_receiver', 'email_receiver', 'address_a', 'address_b', 'price'
	];
	
	public function users()
	{
		$this->belongsTo('App\User');
	}
}
