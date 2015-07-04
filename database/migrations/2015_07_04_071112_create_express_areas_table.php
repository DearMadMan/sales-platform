<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("名称");
            $table->integer('express_id')->comment("指向快递配置信息ID");
            $table->text('config')->comment("记录区域信息");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('express_areas');
    }
}
