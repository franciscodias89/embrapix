<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSafesplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safesplits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('restaurant_id');
            $table->integer('Status');
            $table->integer('IdTransactionSplitter');
            $table->string('Name')->nullable();
            $table->integer('Identity');
            $table->integer('IdReceiver');
            $table->decimal('Amount', 8, 2)->nullable();
            $table->boolean('IsPayTax');
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
        Schema::dropIfExists('safesplits');
    }
}
