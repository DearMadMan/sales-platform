<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_notifies', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->default("")->comment("标题");
            $table->string("type")->default("text")->comment("通知类型");
            $table->string("event")->default("")->comment("激发事件类型");
            $table->text("contents")->comment("内容");
            $table->string("url")->comment("导向链接");
            $table->string("image_url")->comment("图片地址");
            $table->boolean("enabled")->default(false)->comment("启用状态");
            $table->integer("manager_id")->default(0)->comment("所属者ID");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wechat_notifies');
    }
}
