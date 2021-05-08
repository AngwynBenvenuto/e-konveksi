<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPageTable extends Migration
{
    public $set_table = 'cms_page';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_type')->index()->nullable();
            $table->string('title')->index()->nullable();
            $table->text('content');
            $table->string('url_link')->index()->nullable();
            $table->tinyInteger('is_edited')->default(0);
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
