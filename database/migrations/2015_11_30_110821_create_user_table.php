<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('password', 60);
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')
                ->references('id')->on('role')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::drop('user');
    }
}
