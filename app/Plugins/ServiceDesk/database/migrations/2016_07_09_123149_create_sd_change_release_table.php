<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdChangeReleaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_change_release', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('change_id')->unsigned()->nullable();
            $table->foreign('change_id')->references('id')->on('sd_changes');
            $table->integer('release_id')->unsigned()->nullable();
            $table->foreign('release_id')->references('id')->on('sd_releases');
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
        Schema::drop('sd_change_release');
    }
}
