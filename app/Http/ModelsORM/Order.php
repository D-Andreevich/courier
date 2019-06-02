<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


class Order extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	use SpatialTrait;
	
	protected $fillable = [
		'quantity', 'width', 'height', 'depth', 'weight', 'time_of_receipt', 'description', 'distance', 'name_receiver', 'phone_receiver', 'email_receiver', 'address_a', 'address_b', 'price', 'photo', 'coordinate_a', 'coordinate_b', 'status', 'user_id', 'courier_id'
	];
	
	protected $spatialFields = [
		'coordinate_a', 'coordinate_b',
	];
	
	public function users()
	{
		return $this->hasMany('App\User');
	}
	
//	public function usersOrders()
//	{
//		return $this->hasMany('App\UserOrder');
//	}
	
}
