<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransformFeedbackToMorphModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function(Blueprint $table){
            $table->dropForeign('feedback_post_id_foreign');
            $table->renameColumn('post_id','feedbackable_id');
            $table->string('feedbackable_type')->nullable();
        });

        DB::table('feedback')
            ->update(['feedbackable_type' => 'App\Post']);

        DB::statement('ALTER TABLE `feedback` MODIFY `feedbackable_type` VARCHAR(255);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("delete from feedback where feedbackable_type <> 'App\Post'");

        Schema::table('feedback', function(Blueprint $table){
            $table->renameColumn('feedbackable_id', 'post_id');
            $table->foreign('post_id')
                ->references('id')->on('post')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dropColumn('feedbackable_type');
        });
    }
}
