<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 50)->unique()->index();
            $table->string('label');
            $table->string('slug')->unique()->index();
            $table->boolean('enabled');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('expired_at')->nullable();
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
        Schema::drop('collection');
    }
}
