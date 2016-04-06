<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_review', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->text('content');
            $table->boolean('checked');
            $table->float('rate')->unsigned();
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('product')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_review');
    }
}
