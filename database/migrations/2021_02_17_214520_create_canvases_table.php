<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCanvasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvases', function (Blueprint $table) {
            $table->id();
            $table->decimal('width',3,2,true);
            $table->decimal('height',3,2,true);
            $table->unsignedBigInteger('blind_id')->nullable();
            $table->foreign('blind_id')->references('id')->on('blinds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canvases');
    }
}
