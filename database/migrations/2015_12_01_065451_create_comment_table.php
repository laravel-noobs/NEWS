<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table){
            $table->integer('id');
            $table->text('content');
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')
                ->references('id')->on('post')
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
        Schema::drop('comment');
    }
}
