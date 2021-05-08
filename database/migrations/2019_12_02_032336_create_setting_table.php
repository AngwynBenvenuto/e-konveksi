<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
    public $set_table = 'setting';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create($this->set_table, function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('app_name')->index()->nullable();
        //     $table->string('app_code')->index()->nullable();
        //     $table->integer('app_rate')->index()->default(3);
        //     $table->string('firebase_server_key')->nullable();
        //     $table->timestamps();
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
