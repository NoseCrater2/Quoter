<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorVariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_variant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('variant_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('variant_id')->references('id')->on('variants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_variant');
    }
}
