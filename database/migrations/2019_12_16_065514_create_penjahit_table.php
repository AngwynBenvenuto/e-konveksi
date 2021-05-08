<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjahitTable extends Migration
{
    public $set_table = 'penjahit';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('name_display')->nullable();
            $table->string('company')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('districts_id')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('password')->nullable();
            $table->integer('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('phone')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('account_number')->nullable();
            $table->boolean('verified')->default(0);
            $table->string('image_name')->nullable();
            $table->string('image_url')->nullable();
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
