<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('cost');
            $table->integer('contract_type_id')->unsigned()->nullable();
            $table->foreign('contract_type_id')->references('id')->on('sd_contract_types');
            $table->integer('approver_id')->unsigned()->nullable();
            $table->foreign('approver_id')->references('id')->on('sd_cab');
            $table->integer('vendor_id')->unsigned()->nullable();
            $table->foreign('vendor_id')->references('id')->on('sd_vendors');
            $table->integer('license_type_id')->unsigned()->nullable();
            $table->foreign('license_type_id')->references('id')->on('sd_license_types');
            $table->integer('licensce_count');
            //            $table->integer('attachment')->unsigned();
            //            $table->foreign('attachment')->references('id')->on('sd_attachments');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('sd_products');
            $table->timestamp('notify_expiry')->nullable();
            $table->timestamp('contract_start_date')->nullable();
            $table->timestamp('contract_end_date')->nullable();
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
        Schema::drop('sd_contracts');
    }
}
