<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSafetransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safetransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('restaurant_id');
            $table->integer('Status');
            $table->string('Message')->nullable();
            $table->dateTime("PaymentDate")->nullable();
            $table->dateTime("CreatedDate")->nullable();
            $table->decimal('Amount', 8, 2)->nullable();
            $table->decimal('NetValue', 8, 2)->nullable();
            $table->decimal('TaxValue', 8, 2)->nullable();
            $table->decimal('NegotiationTax', 8, 2)->nullable();
            $table->boolean('IsTransferred');
            $table->dateTime("ReleaseDate")->nullable();
            $table->string("PaymentMethod")->nullable();
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
        Schema::dropIfExists('safetransactions');
    }
}
