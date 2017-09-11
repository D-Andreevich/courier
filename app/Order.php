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
		'id', 'quantity', 'width', 'height', 'depth', 'weight', 'time_of_receipt', 'description', 'distance', 'name_receiver', 'phone_receiver', 'email_receiver', 'address_a', 'address_b', 'price', 'coordinate_a', 'coordinate_b', 'user_id',
	];
	
	protected $spatialFields = [
		'coordinate_a', 'coordinate_b',
	];
	
	public function users()
	{
		return $this->belongsToMany('App\User', 'users_orders');
	}
	
	public function usersOrders()
	{
		return $this->hasMany('App\UserOrder');
	}
	
}
