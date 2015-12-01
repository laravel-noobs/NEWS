<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table){
            $table->integer('id');
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')
                ->references('id')->on('post')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('content');
            $table->boolean('checked');
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
        Schema::drop('feedback');
    }
}
