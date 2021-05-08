<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    public $set_table = 'transaction';
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
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('ikm_id')->nullable();
            $table->string('owner_project')->nullable();
            $table->string('type')->index()->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('transaction_price')->nullable();
            $table->string('transaction_total')->nullable();
            $table->string('transaction_status')->nullable()->comments('Pending, Approve, Cancel');
            $table->string('progress')->nullable();
            $table->text('payment_confirmed')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists($this->set_table);
    }
}
