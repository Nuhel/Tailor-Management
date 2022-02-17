<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderServicDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_servic_designs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_service_id');

            $table->bigInteger('service_design_id');
            $table->string('design_name')->nullable();

            $table->bigInteger('service_design_style_id');
            $table->string('style_name')->nullable();
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
        Schema::dropIfExists('order_servic_designs');
    }
}
