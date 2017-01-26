<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdCabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_cab', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('head')->unsigned()->nullable();
            $table->foreign('head')->references('id')->on('users');
            $table->string('approvers')->nullable();
            $table->integer('aproval_mandatory');
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
        Schema::drop('sd_cab');
    }
}
