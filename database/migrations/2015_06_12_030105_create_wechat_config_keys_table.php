<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatConfigKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_config_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string("key")->comment("配置信息关键字");
            $table->string("default_value")->default("")->comment("默认值");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wechat_config_keys');
    }
}
