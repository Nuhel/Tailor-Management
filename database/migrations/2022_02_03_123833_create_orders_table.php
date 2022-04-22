<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->bigInteger('customer_id');
            $table->bigInteger('master_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->date('delivery_date');
            $table->date('delivered_at')->nullable();
            $table->date('trial_date')->nullable();;
            $table->date('order_date');
            $table->double('total');
            $table->double('discount')->nullable();
            $table->double('netpayable');
            $table->double('initially_paid');
            $table->double('initial_due');
            $table->boolean('is_sale')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
