<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserAddColumnDeliveryWardId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function(Blueprint $table) {
            $table->string('delivery_ward_id', 5)->nullable();

            $table->foreign('delivery_ward_id')
                ->references('id')->on('ward')
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
        Schema::table('user', function (Blueprint $table) {
            $table->dropForeign('user_delivery_ward_id_foreign');
            $table->dropColumn('delivery_ward_id');
        });
    }
}
