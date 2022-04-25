<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double("amount");
            $table->dateTime("transaction_date");
            $table->text("description")->nullable();
            $table->morphs("transactionable");
            $table->nullableMorphs("sourceable");
            $table->enum('type', ['Debit', 'Credit']);
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('order_service_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
