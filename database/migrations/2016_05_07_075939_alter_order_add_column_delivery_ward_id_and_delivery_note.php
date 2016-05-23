<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderAddColumnDeliveryWardIdAndDeliveryNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function(Blueprint $table) {
            $table->string('delivery_ward_id', 5);
            $table->text('delivery_note');

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
        Schema::table('order', function (Blueprint $table) {
            $table->dropForeign('order_delivery_ward_id_foreign');
            $table->dropColumn('delivery_ward_id');
            $table->dropColumn('delivery_note');
        });
    }
}
