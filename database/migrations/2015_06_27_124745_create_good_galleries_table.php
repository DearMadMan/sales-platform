<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('good_id')->commen('所属商品id');
            $table->string('date_dir')->comment('图片所在日期目录');
            $table->string('file_name')->comment('图片名称');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('good_galleries');
    }
}
