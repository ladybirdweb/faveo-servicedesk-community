<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('manufacturer');
            //            $table->integer('asset_type_id')->unsigned()->nullable();
            //            $table->foreign('asset_type_id')->references('id')->on('sd_asset_types');
            $table->integer('product_status_id')->unsigned()->nullable();
            $table->foreign('product_status_id')->references('id')->on('sd_product_status');
            $table->integer('product_mode_procurement_id')->unsigned()->nullable();
            $table->foreign('product_mode_procurement_id')->references('id')->on('sd_product_proc_mode');
            $table->integer('all_department')->nullable();
            $table->integer('status')->nullable();
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
        Schema::drop('sd_products');
    }
}
