<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenawaranTable extends Migration
{
    public $set_table = 'offers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('penjahit_id')->index()->nullable();
            $table->unsignedBigInteger('ikm_id')->index()->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('type')->index()->default('bid');
            $table->string('code')->nullable();
            $table->string('offer_price')->nullable();
            $table->text('note')->nullable();
            $table->text('attachment')->nullable();
            $table->tinyInteger('is_approve_ikm')->default(0);
            $table->dateTime('date_approve_ikm')->index()->nullable();
            $table->tinyInteger('is_approve_penjahit')->default(0);
            $table->dateTime('date_approve_penjahit')->index()->nullable();
            $table->dateTime('last_approve')->nullable();
            $table->dateTime('last_request')->nullable();
            $table->string('status_confirm')->nullable()->default('Pending')->comments('Pending, Approve, Cancel');
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
        Schema::dropIfExists($this->set_table);
    }
}
