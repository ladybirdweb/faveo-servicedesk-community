<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdProductVendorRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_product_vendor_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->integer('vendor_id')->nullable();
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
        Schema::drop('sd_product_vendor_relation');
    }
}
