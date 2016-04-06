<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransformPostTagToTaggableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('post_tag', function(Blueprint $table) {
            $table->dropPrimary(['tag_id', 'post_id']);

            $table->dropForeign('post_tag_post_id_foreign');

            $table->renameColumn('post_id','taggable_id');
            $table->string('taggable_type')->nullable();
        });

        DB::table('post_tag')
            ->update(['taggable_type' => 'App\Post']);

        DB::statement('ALTER TABLE `post_tag` MODIFY `taggable_type` VARCHAR(255);');

        Schema::table('post_tag', function (Blueprint $table) {
            $table->primary(['tag_id', 'taggable_id', 'taggable_type']);
        });

        Schema::rename('post_tag', 'taggable');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('taggable'))
        {
            DB::delete("delete from taggable where taggable_type <> 'App\Post'");

            Schema::table('taggable', function(Blueprint $table){
                $table->dropPrimary('tag_id', 'taggable_id', 'taggable_type');

                $table->renameColumn('taggable_id', 'post_id');
                $table->foreign('post_id')
                    ->references('id')->on('post')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->primary(['tag_id', 'post_id']);

                $table->dropColumn('taggable_type');
            });

            Schema::rename('taggable', 'post_tag');
        }
    }
}
