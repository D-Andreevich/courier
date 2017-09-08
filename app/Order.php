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
		'user_id', 'quantity', 'width', 'height', 'depth', 'weight', 'time_of_receipt', 'description', 'is_vehicle', 'name_receiver', 'phone_receiver', 'email_receiver', 'address_a', 'address_b', 'price', 'coordinate_a', 'coordinate_b',
    ];

    protected $spatialFields = [
        'coordinate_a','coordinate_b',
    ];

	public function users()
	{
		$this->belongsTo('App\User');
	}
}
