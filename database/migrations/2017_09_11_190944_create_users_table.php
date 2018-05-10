<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50);
                $table->char('phone')->unique();
                $table->string('email', 50)->unique();
                $table->string('password');
                $table->string('avatar');
                $table->decimal('rating', '2', '1')->default(0);
                $table->integer('total_rating')->unsigned()->default(0);
                $table->geometry('current_position')->nullable();
                $table->integer('total_rates')->unsigned()->default(0);
                $table->string('avatar')->default('/uploads/avatars/default.jpg')->change();
                $table->decimal('social_id', '30', '0');
                $table->boolean('is_tracking')->default(0);
                $table->boolean('activated')->default(false);
                $table->rememberToken();
                $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
