<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('notification_id')->nullable();
            $table->unsignedBigInteger('penawaran_id')->nullable();
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('ikm_id')->nullable();
            $table->string('ikm_name')->nullable();
            $table->unsignedBigInteger('penjahit_id')->nullable();
            $table->string('penjahit_name')->nullable();
            $table->tinyInteger('is_opened')->comments('read/open')->default(0);
            $table->tinyInteger('is_send')->default(0);
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
        Schema::dropIfExists('notification_detail');
    }
}
