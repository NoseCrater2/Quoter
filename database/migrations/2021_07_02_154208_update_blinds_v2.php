<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBlindsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //extraEnrollable
        //extraVertical
        Schema::table('blinds', function (Blueprint $table) {
            $table->decimal('extraEnrollable',8,2)->default(0);
            $table->decimal('extraVertical',8,2)->default(0);
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
