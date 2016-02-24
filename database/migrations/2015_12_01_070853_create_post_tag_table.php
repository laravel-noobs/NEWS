<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table){
            $table->unsignedInteger('post_id')->index();
            $table->foreign('post_id')
                ->references('id')->on('post')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('tag_id')->index();
            $table->foreign('tag_id')
                ->references('id')->on('tag')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->primary(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_tag');
    }
}
