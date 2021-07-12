<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubweaveWeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subweave_weave', function (Blueprint $table) {
            $table->unsignedBigInteger('weave_id');
            $table->unsignedBigInteger('subweave_id');
            $table->foreign('weave_id')->references('id')->on('weaves');
            $table->foreign('subweave_id')->references('id')->on('subweaves');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subweave_weave');
    }
}
