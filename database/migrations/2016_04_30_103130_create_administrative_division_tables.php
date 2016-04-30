<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrativeDivisionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province_type', function (Blueprint $table){
            $table->unsignedTinyInteger('id')->index();
            $table->string('name', 25);
            $table->primary(['id']);
        });

        Schema::create('district_type', function (Blueprint $table){
            $table->unsignedTinyInteger('id')->index();
            $table->string('name', 25);
            $table->primary(['id']);
        });

        Schema::create('ward_type', function (Blueprint $table){
            $table->unsignedTinyInteger('id')->index();
            $table->string('name', 25);
            $table->primary(['id']);
        });

        //
        Schema::create('province', function (Blueprint $table){
            $table->string('id', 5)->index();
            $table->string('name', 100);
            $table->unsignedTinyInteger('type_id');
            $table->primary(['id']);

            $table->foreign('type_id')
                ->references('id')->on('province_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

        });

        Schema::create('district', function (Blueprint $table){
            $table->string('id', 5)->index();
            $table->string('name', 100);
            $table->string('location', 30);
            $table->unsignedTinyInteger('type_id');
            $table->string('province_id', 5);
            $table->primary(['id']);

            $table->foreign('type_id')
                ->references('id')->on('district_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('province_id')
                ->references('id')->on('province')
                ->onDelete('restrict')
                ->onUpdate('cascade');

        });

        Schema::create('ward', function (Blueprint $table){
            $table->string('id', 5)->index();
            $table->string('name', 100);
            $table->string('location', 30);
            $table->unsignedTinyInteger('type_id');
            $table->string('district_id', 5);
            $table->primary(['id']);

            $table->foreign('type_id')
                ->references('id')->on('ward_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('district_id')
                ->references('id')->on('district')
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
        Schema::drop('ward');
        Schema::drop('district');
        Schema::drop('province');
        Schema::drop('ward_type');
        Schema::drop('district_type');
        Schema::drop('province_type');
    }
}
