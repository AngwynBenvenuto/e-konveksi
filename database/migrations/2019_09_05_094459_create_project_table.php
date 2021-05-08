<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    public $set_table = 'project';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ikm_id')->nullable();
            $table->string('name', 30)->index()->nullable();
            $table->string('code', 30)->index()->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->text('spesification')->nullable();
            $table->string('size_guide_anak')->nullable();
            $table->string('size_guide_dewasa')->nullable();
            $table->string('video_url')->nullable();
            $table->string('qr_code')->nullable();
            $table->integer('views')->nullable();
            $table->tinyInteger('is_publish')->default(1);
            $table->tinyInteger('is_bookmark')->default(0);
            $table->tinyInteger('is_project_private')->nullable();
            $table->dateTime('published_date')->nullable();
            $table->integer('deadline')->nullable()->comment('dalam bulan');
            $table->tinyInteger('tailor')->nullable();
            $table->tinyInteger('is_signed_tailor')->nullable();
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
