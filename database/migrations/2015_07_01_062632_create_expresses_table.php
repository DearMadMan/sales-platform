<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('快递名称');
            $table->string('desc')->comment('快递简介');
            $table->string('code')->comment('快递代码:快递100');
            $table->text('config')->comment('插件初始化配置信息');
            $table->boolean('enable')->default(false)->comment('启用状态');
            $table->integer('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('expresses');
    }
}
