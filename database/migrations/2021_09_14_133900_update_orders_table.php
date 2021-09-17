<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blinds', function (Blueprint $table) {
            $table->dropForeign('variant_id_foreign');
            $table->dropColumn('variant_id');
            $table->dropForeign('second_variant_id_foreign');
            $table->dropColumn('second_variant_id');
            $table->string('variant')->required();
            $table->string('second_variant')->nullable();
            
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
