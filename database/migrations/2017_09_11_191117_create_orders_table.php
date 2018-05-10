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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('region')->nullable();
                $table->integer('quantity')->default(1);
                $table->integer('width')->default(0);
                $table->integer('height')->default(0);
                $table->integer('depth')->default(0);
                $table->float('weight', 8, 2);
                $table->dateTime('time_of_receipt');
                $table->text('description')->nullable();
                $table->string('name_receiver', 100);
                $table->char('phone_receiver');
                $table->string('email_receiver');
                $table->string('address_a');
                $table->string('address_b');
                $table->integer('distance');
                $table->decimal('price', 10, 2);
                $table->geometry('coordinate_a')->nullable();
                $table->geometry('coordinate_b')->nullable();
                $table->geometry('current_position')->nullable();
                $table->string('status');
                $table->string('photo');
                $table->integer('user_id')->unsigned()->default(0);
                $table->integer('courier_id')->unsigned()->default(0);
                $table->boolean('is_rate')->default(0);
                $table->string('taken_token')->nullable();
                $table->string('delivered_token')->nullable();
                $table->timestamps();
            });
        }
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
