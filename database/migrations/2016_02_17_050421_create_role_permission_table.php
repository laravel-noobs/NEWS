<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function(Blueprint $table) {
            $table->smallInteger('role_id')->unsigned();
            $table->smallInteger('permission_id')->unsigned();
            $table->primary(['role_id', 'permission_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on('role')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('role')
                ->onDelete('cascade')
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
        Schema::drop('role_permission');
    }
}
