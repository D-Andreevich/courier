<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
	        $table->integer('user_id')->unsigned();
	        $table->integer('quantity')->default(1);
	        $table->integer('width')->default(0);
	        $table->integer('height')->default(0);
	        $table->integer('depth')->default(0);
	        $table->float('weight', 8, 2);
	        $table->dateTime('time_of_receipt');
	        $table->text('description')->nullable();
	        $table->boolean('is_vehicle');
	        $table->string('name_receiver', 100);
	        $table->char('phone_receiver');
	        $table->string('email_receiver');
	        $table->string('address_a');
	        $table->string('address_b');
	        $table->float('distance', 10, 2);
	        $table->decimal('price', 10, 2);
	        $table->string('status');
	        $table->timestamps();
        });
    }

    /**1
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
