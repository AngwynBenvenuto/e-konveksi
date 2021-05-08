<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjahitAddressTable extends Migration
{
    public $set_table = "penjahit_address";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create($this->set_table, function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('penjahit_id')->nullable();
        //     $table->string('type', 20)->nullable();
        //     $table->string('name', 50)->nullable();
        //     $table->string('phone', 50)->nullable();
        //     $table->string('address')->nullable();
        //     $table->string('email', 50)->nullable();
        //     $table->string('postal', 30)->nullable();
        //     $table->unsignedBigInteger('province_id')->nullable();
        //     $table->unsignedBigInteger('city_id')->nullable();
        //     $table->unsignedBigInteger('districts_id')->nullable();
        //     $table->string('lat')->nullable();
        //     $table->string('long')->nullable();
        //     $table->tinyInteger('is_active')->default(0);
        //     $table->timestamps();
        //     $table->tinyInteger('status')->default(1);
        // });
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
