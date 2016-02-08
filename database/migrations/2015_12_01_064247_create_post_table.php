<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->integer('view');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedSmallInteger('status_id');
            $table->foreign('status_id')
                ->references('id')->on('post_status')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedSmallInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')->on('category')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->boolean('published')->default(false);
            $table->timestamp('published_at');
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
        Schema::drop('post');
    }
}
