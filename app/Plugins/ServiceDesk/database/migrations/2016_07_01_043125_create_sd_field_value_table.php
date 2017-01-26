<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdFieldValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_field_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('field_id')->unsigned()->nullable();
            $table->foreign('field_id')->references('id')->on('sd_form_fields');
            $table->string('option');
            $table->string('value');
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
        Schema::drop('field_values');
    }
}
