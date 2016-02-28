<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function(Blueprint $table){
            $table->increments('id');
            $table->string('customer_name');
            $table->string('phone', 20);
            $table->string('delivery_address', 20);
            $table->unsignedSmallInteger('status_id');
            $table->foreign('status_id')
                ->references('id')->on('product_status')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order');
    }
}
