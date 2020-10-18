<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitVariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limit_variant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('limit_id');
            $table->unsignedBigInteger('variant_id');
            $table->foreign('limit_id')->references('id')->on('limits');
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
        Schema::dropIfExists('limit_variant');
    }
}
