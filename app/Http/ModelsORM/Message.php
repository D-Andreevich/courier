<?php

namespace App\Http\ModelsORM;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable =[
      'message', 'author', 'recipient'
    ];
}
