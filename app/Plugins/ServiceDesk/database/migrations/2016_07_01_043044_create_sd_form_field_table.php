<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdFormFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->integer('form_id')->unsigned()->nullable();
            $table->foreign('form_id')->references('id')->on('sd_forms');
            $table->string('type');
            $table->string('sub_type');
            $table->string('class');
            $table->string('is_required');
            $table->string('placeholder');
            $table->string('description');
            $table->string('multiple');
            $table->integer('role');
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
        Schema::drop('form_fields');
    }
}
