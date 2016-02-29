<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission', function(Blueprint $table){
            $table->smallIncrements('id');
            $table->string('name', 50)->unique()->index();
            $table->string('label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voSid
     */
    public function down()
    {
        Schema::drop('permission');
    }
}
