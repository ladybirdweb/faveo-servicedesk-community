<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from');
            $table->string('subject');
            $table->string('department');
            $table->string('description');
            $table->integer('status_type_id')->unsigned()->nullable();
            //$table->foreign('status_type_id')->references('id')->on('sd_status_types');
            $table->integer('priority_id')->unsigned()->nullable();
            //$table->foreign('priority_id')->references('id')->on('sd_priority_types');
            $table->integer('impact_id')->unsigned()->nullable();
            //$table->foreign('impact_id')->references('id')->on('sd_impact');
            $table->integer('location_type_id')->unsigned()->nullable();
            //$table->foreign('location_type_id')->references('id')->on('sd_location_types');
            $table->integer('group_id')->unsigned()->nullable();
            // $table->foreign('group_id')->references('id')->on('sd_group');
            $table->integer('agent_id')->unsigned()->nullable();
            // $table->foreign('agent_id')->references('id')->on('sd_agent');
            $table->integer('assigned_id')->unsigned()->nullable();
            //$table->foreign('assigned_id')->references('id')->on('sd_assigned');
            //$table->integer('attachment')->unsigned()->nullable();
            //$table->foreign('attachment')->references('id')->on('sd_attachments');

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
        Schema::drop('sd_problem');
        //
    }
}
