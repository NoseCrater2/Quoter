<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturerSunblindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturer_sunblind', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('sunblind_id');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->foreign('sunblind_id')->references('id')->on('sunblinds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacturer_sunblind');
    }
}
