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
        //        if(Schema::hasTable('post_tag'))
//        {
        Schema::table('post_tag', function(Blueprint $table) {
            $table->dropForeign('post_tag_post_id_foreign');

            $table->renameColumn('post_id','taggable_id');
            $table->string('taggable_type')->nullable();
        });

        DB::table('post_tag')
            ->update(['taggable_type' => 'App\Post']);

        DB::statement('ALTER TABLE `post_tag` MODIFY `taggable_type` VARCHAR(255);');

        Schema::rename('post_tag', 'taggable');
//        }
//        else
//        {
//            Schema::create('taggable', function (Blueprint $table){
//                $table->unsignedInteger('tag_id')->index();
//                $table->unsignedInteger('taggable_id')->index();
//                $table->string('taggable_type')->index();
//
//                $table->foreign('tag_id')
//                    ->references('id')->on('tag')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//
//                $table->primary(['tag_id', 'taggable_id', 'taggable_type']);
//            });
//        }

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

            Schema::table('taggable', function(Blueprint $table){
                $table->renameColumn('taggable_id', 'post_id');
                $table->foreign('post_id')
                    ->references('id')->on('post')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->dropColumn('taggable_type');
            });

            Schema::rename('taggable', 'post_tag');
        }
    }
}
