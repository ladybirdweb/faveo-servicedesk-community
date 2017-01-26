<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdCabVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_cab_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cab_id')->unsigned()->nullable();
            $table->foreign('cab_id')->references('id')->on('sd_cab');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('comment');
            $table->string('owner');
            $table->integer('vote');
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
        Schema::drop('sd_cab_votes');
    }
}
