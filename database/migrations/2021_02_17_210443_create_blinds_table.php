<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blinds', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->boolean('cloth_holder')->default(false);
            $table->enum('control_side',['Izquierdo', 'Derecho'])->nullable();
            $table->integer('panels')->default(0);
            $table->string('control_color')->nullable();
            $table->string('grouping')->nullable();
            $table->string('manufacturer')->nullable();
            $table->enum('string_type',['plastico', 'metal'])->nullable();
            
            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')->references('id')->on('variants');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->unsignedBigInteger('gallery_id')->nullable();
            $table->foreign('gallery_id')->references('id')->on('galleries');
            $table->unsignedBigInteger('motorization_id')->nullable();
            $table->foreign('motorization_id')->references('id')->on('motorizations');
            $table->unsignedBigInteger('control_id')->nullable();
            $table->foreign('control_id')->references('id')->on('controls');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blinds');
    }
}
