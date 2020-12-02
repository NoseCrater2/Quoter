<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->required();
            $table->string('slug')->required();
            $table->string('image')->nullable();
            $table->decimal('max_width',3,2,true)->default(0);
            $table->decimal('min_width',3,2,true)->default(0);
            $table->decimal('max_height',3,2,true)->default(0);
            $table->decimal('min_height',3,2,true)->default(0);
            $table->decimal('max_width_rot',3,2,true)->default(0);
            $table->decimal('min_width_rot',3,2,true)->default(0);
            $table->decimal('max_height_rot',3,2,true)->default(0);
            $table->decimal('min_height_rot',3,2,true)->default(0);
            $table->decimal('profit_margin',3,2,true)->default(0);
            $table->unsignedBigInteger('product_id')->required()->default(1);
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
