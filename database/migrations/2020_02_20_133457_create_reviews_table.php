<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->unsignedBigInteger('ikm_id')->nullable();
            $table->unsignedBigInteger('penjahit_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->text('note');
            $table->integer('rating')->nullable();
            $table->datetime('rating_request')->nullable();
            // $table->tinyInteger('is_sign_ikm')->nullable();
            // $table->tinyInteger('is_sign_penjahit')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
