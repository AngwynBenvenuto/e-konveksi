<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    public $set_table = 'country';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create($this->set_table, function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('code', 10)->nullable();
        //     $table->string('name')->nullable();
        //     $table->string('phone_code', 10)->nullable();
        //     $table->timestamps();
        //     $table->tinyInteger('status')->nullable()->default(1);
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
