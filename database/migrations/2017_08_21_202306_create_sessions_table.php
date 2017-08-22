<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('name');
	        $table->string('lastname');
	        $table->string('middlename');
	        $table->char('phone');
	        $table->string('email')->unique();
	        $table->string('password');
	        $table->boolean('is_customer');
	        $table->boolean('is_courier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
