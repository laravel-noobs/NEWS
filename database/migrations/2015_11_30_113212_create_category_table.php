<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 50);
            $table->string('slug', 50)->unique();
            $table->string('description');
            $table->unsignedSmallInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('category')
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
        Schema::drop('category');
    }
}
