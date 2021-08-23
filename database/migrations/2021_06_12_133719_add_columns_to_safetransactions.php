<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSafetransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('safetransactions', function (Blueprint $table) {
         
            $table->decimal('credit_card_percent', 8, 2)->nullable();
            $table->decimal('debit_card_percent', 8, 2)->nullable();
            $table->decimal('pix_percent', 8, 2)->nullable();
            $table->decimal('comission', 8, 2)->nullable();
            $table->integer('plan_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('safetransactions', function (Blueprint $table) {
            //
        });
    }
}
