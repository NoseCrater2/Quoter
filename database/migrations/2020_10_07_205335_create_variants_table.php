<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->required();
            $table->decimal('price',7,2,true)->default(0);
            $table->decimal('width',3,2,true)->default(0);
            $table->tinyInteger('rotate')->default(0);
            // $table->text('description')->nullable();
            // $table->string('finished')->nullable();
            // $table->decimal('strip_width',3,2,true)->default(0);

            // $table->decimal('ceiling_price',7,2,true)->default(0);
            // $table->decimal('wall_price',7,2,true)->default(0);
            // $table->decimal('wall_extended_price',7,2,true)->default(0);
            // $table->decimal('wall_double_price',7,2,true)->default(0);
            // $table->decimal('ceiling_wall_price',7,2,true)->default(0);
            // $table->decimal('curve_price',7,2,true)->default(0);
            
            // $table->unsignedBigInteger('weave_id')->nullable();
            // $table->foreign('weave_id')->references('id')->on('weaves');

            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('types');

            $table->unsignedBigInteger('line_id')->nullable();
            $table->foreign('line_id')->references('id')->on('lines');

            $table->unsignedBigInteger('weave_id')->nullable();
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
        Schema::dropIfExists('variants');
    }
}
