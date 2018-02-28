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
           $table->string('taken_token')->nullable();
           $table->string('delivered_token')->nullable();
            $table->renameColumn('user_id', 'courier_id');
            $table->boolean('is_rate')->default(0)->after('courier_id');
            $table->integer('user_id')->after('courier_id')->unsigned();
            $table->string('region')->nullable()->after('id');
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
