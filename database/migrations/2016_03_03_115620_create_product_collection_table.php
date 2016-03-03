<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_collection', function (Blueprint $table){
            $table->unsignedInteger('product_id')->index();
            $table->unsignedSmallInteger('collection_id')->index();

            $table->foreign('product_id')
                ->references('id')->on('product')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('collection_id')
                ->references('id')->on('collection')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['product_id', 'collection_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_collection');
    }
}
