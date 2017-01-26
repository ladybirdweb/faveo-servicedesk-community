<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdProblemChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_problem_change', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('problem_id')->unsigned()->nullable();
            $table->foreign('problem_id')->references('id')->on('sd_problem');
            $table->integer('change_id')->unsigned()->nullable();
            $table->foreign('change_id')->references('id')->on('sd_changes');
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
        Schema::drop('sd_problem_change');
    }
}
