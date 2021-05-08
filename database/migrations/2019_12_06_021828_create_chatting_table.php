<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChattingTable extends Migration
{
    public $set_table = 'chatting';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->integer('sender')->nullable();
            $table->string('sender_unique')->nullable();
            $table->integer('receiver')->nullable();
            $table->string('receiver_unique')->nullable();
            $table->text('message')->nullable();
            $table->dateTime('send_date')->nullable();
            $table->tinyInteger('is_read')->nullable();
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
