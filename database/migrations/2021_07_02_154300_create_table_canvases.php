<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCanvases extends Migration
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
            $table->decimal('width',4,2,true)->default(0);
            $table->decimal('height',4,2,true)->default(0);
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
