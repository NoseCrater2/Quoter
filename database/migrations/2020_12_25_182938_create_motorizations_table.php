<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motorizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->required();
            $table->integer('canvas')->default(0);
            $table->string('system')->nullable();
            $table->decimal('width',3,2,true)->default(0);
            $table->decimal('height',3,2,true)->default(0);
            $table->decimal('price',7,2,true)->default(0);
            $table->integer('via')->default(0);
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');
            $table->unsignedBigInteger('motorization_type_id')->nullable();
            $table->foreign('motorization_type_id')->references('id')->on('motorization_types');
            $table->unsignedBigInteger('line_id');
            $table->foreign('line_id')->references('id')->on('lines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motorizations');
    }
}
