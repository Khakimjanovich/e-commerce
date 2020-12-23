<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionShippingMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_shipping_method', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->index();
            $table->unsignedBigInteger('shipping_method_id')->index();

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_shipping_method');
    }
}
