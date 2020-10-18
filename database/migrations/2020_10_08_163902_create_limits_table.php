<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('width',4,2,true)->required();
            $table->decimal('height',4,2,true)->required();
            $table->decimal('limit_height',4,2,true)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limits');
    }
}
