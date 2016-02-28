<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rate', function (Blueprint $table){
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('product_id')->index();
            $table->foreign('product_id')
                ->references('id')->on('product')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->primary(['user_id', 'product_id']);
            $table->float('rate')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_rate');
    }
}
