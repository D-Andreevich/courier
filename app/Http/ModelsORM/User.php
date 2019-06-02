<?php

namespace App\Http\ModelsORM;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'phone', 'email', 'password', 'social_id', 'avatar', 'is_tracking'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public function orders()
	{
		return $this->belongsToMany(Order::class, 'users_orders')->withTimestamps();
	}
	
}
