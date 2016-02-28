<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('description');
            $table->integer('view');
            $table->string('image');
            $table->decimal('price', 10, 2)->unsigned();
            $table->unsignedInteger('user_id');
            $table->unsignedSmallInteger('status_id');
            $table->foreign('status_id')
                ->references('id')->on('product_status')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedSmallInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')->on('product_category')
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
        Schema::drop('product');
    }
}
