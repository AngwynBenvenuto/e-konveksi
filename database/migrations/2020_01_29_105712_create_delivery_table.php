<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('ikm_id')->nullable();
            $table->unsignedBigInteger('penjahit_id')->nullable();
            $table->string('order_invoice')->nullable();
            $table->string('project_name')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->unsignedBigInteger('buyer_province_id')->nullable();
            $table->string('buyer_province_name')->nullable();
            $table->unsignedBigInteger('buyer_city_id')->nullable();
            $table->string('buyer_city_name')->nullable();
            $table->string('bank')->nullable();
            $table->string('courier')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_total')->nullable();
            $table->tinyInteger('delivery_progress')->nullable();
            $table->text('barang')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery');
    }
}
