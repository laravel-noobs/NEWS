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
            $table->string('delivery_address');
            $table->dateTime('canceled_at');

            $table->unsignedSmallInteger('status_id');
            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('status_id')
                ->references('id')->on('product_status')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
