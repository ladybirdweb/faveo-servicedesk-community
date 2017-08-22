<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('subject');
            $table->integer('requester')->unsigned()->nullable();
            $table->foreign('requester')->references('id')->on('users');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('sd_change_status');
            $table->integer('priority_id')->unsigned()->nullable();
            $table->foreign('priority_id')->references('id')->on('sd_change_priorities');
            $table->integer('change_type_id')->unsigned()->nullable();
            $table->foreign('change_type_id')->references('id')->on('sd_change_types');
            $table->integer('impact_id')->unsigned()->nullable();
            $table->foreign('impact_id')->references('id')->on('sd_impact_types');
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('sd_locations');
            $table->integer('approval_id')->unsigned()->nullable();
            $table->foreign('approval_id')->references('id')->on('sd_cab');
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
        Schema::drop('sd_changes');
    }
}
