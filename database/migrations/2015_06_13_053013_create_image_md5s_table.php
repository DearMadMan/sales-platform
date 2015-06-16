<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageMd5sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_md5s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date_dir')->comment("上传时间目录名");
            $table->string('file_name')->comment("文件名");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image_md5s');
    }
}
