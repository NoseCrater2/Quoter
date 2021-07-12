<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBlindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blinds', function (Blueprint $table) {
            $table->string('celular_drive')->nullable();
            $table->string('celular_type')->nullable();
            $table->string('celular_variant')->nullable();
            $table->string('instalation_side')->nullable();
            $table->string('motor_type')->nullable();
            $table->decimal('price',8,2)->default(0);
            $table->boolean('rotate')->default(false);
            $table->tinyInteger('canvas')->default(0);
            $table->string('comment')->nullable();
            $table->string('drive')->nullable();
            $table->decimal('flexiballet_price',8,2)->default(0);
            $table->string('frame')->nullable();
            $table->decimal('gallery_price',8,2)->default(0);
            $table->string('height_control')->nullable();
            $table->string('motor_instalation_side')->nullable();
            $table->decimal('manufacturer_price',8,2)->default(0);
            $table->decimal('control_price',8,2)->default(0);
            $table->string('rail_color')->nullable();
            $table->decimal('string_price',8,2)->default(0);
            $table->boolean('is_quotation')->default(false);
            $table->unsignedBigInteger('second_variant_id')->nullable();
            $table->foreign('second_variant_id')->references('id')->on('variants');
            $table->unsignedBigInteger('second_color_id');
            $table->foreign('second_color_id')->references('id')->on('colors')->nullable();
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
