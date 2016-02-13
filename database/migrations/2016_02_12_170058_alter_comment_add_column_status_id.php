<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCommentAddColumnStatusId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment', function(Blueprint $table){
            $table->unsignedSmallInteger('status_id');
            $table->foreign('status_id')
                ->references('id')->on('comment_status')
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
        Schema::table('comment', function(Blueprint $table){
            $table->dropForeign('comment_status_id_foreign');
            $table->dropColumn('status_id');
        });
    }
}
