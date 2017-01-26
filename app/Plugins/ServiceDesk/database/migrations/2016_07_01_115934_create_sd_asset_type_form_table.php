<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdAssetTypeFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_asset_type_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_type_id')->unsigned()->nullable();
            $table->integer('form_id')->unsigned()->nullable();
            $table->foreign('asset_type_id')->references('id')->on('sd_asset_types');
            $table->foreign('form_id')->references('id')->on('sd_forms');
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
        Schema::drop('sd_asset_type_form');
    }
}
