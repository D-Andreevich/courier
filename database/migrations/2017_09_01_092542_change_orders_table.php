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
		if (Schema::hasTable('orders')) {
			
			Schema::table('orders', function (Blueprint $table) {
				$table->renameColumn('is_active', 'is_enable');
				$table->foreign('user_id')->references('id')->on('users');
			});
		}
		
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
