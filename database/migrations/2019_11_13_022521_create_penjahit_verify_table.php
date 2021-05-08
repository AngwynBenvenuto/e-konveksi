<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjahitVerifyTable extends Migration
{
    public $set_table = 'penjahit_verify';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('penjahit_id')->nullable();
            $table->string('type')->nullable()->index()->comments('email / phone');
            $table->string('verify_code')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('token')->nullable()->index();
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
        Schema::dropIfExists($this->set_table);
    }
}
