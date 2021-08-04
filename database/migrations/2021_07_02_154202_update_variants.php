<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->string('weight')->nullable();
            $table->string('polyester')->nullable();
            $table->string('acrylic')->nullable();
            $table->string('pvc')->nullable();
        });
    }
    // Peso: (se mide en gramos)
    // Polyester: (en porcentaje)
    // Acrílico: (en porcentaje)
    // PVC: (en porcentaje)
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
