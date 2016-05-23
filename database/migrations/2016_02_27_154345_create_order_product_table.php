<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function(Blueprint $table){
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->decimal('price', 10, 2)->unsigned();
            $table->smallInteger('quantity')->unsigned();

            $table->foreign('product_id')
                ->references('id')->on('product')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('order_id')
                ->references('id')->on('order')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_product');
    }
}
