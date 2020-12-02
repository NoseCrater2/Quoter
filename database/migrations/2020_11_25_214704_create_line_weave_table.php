<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineWeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_weave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('line_id');
            $table->unsignedBigInteger('weave_id');
            $table->foreign('line_id')->references('id')->on('lines');
            $table->foreign('weave_id')->references('id')->on('weaves');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_weave');
    }
}
