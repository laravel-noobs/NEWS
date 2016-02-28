<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransformCommentToMorphModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment', function(Blueprint $table) {
            $table->dropForeign('comment_post_id_foreign');
            $table->renameColumn('post_id','commentable_id');
            $table->string('commentable_type')->nullable();
        });

        DB::table('comment')
            ->update(['commentable_type' => 'App\Post']);

        DB::statement('ALTER TABLE `comment` MODIFY `commentable_type` VARCHAR(255);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment', function(Blueprint $table){
            $table->renameColumn('commentable_id', 'post_id');
            $table->foreign('post_id')
                ->references('id')->on('post')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dropColumn('commentable_type');
        });
    }
}
