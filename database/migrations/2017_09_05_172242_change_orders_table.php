<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::table('orders', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users');
                $table->geometry('coordinate_a')->nullable();
                $table->geometry('coordinate_b')->nullable();
                $table->geometry('current_position')->nullable();
			});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function (Blueprint $table) {
			//
		});
	}
}
