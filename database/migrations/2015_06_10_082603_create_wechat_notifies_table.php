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
            $table->string("title")->default("");
            $table->string("type")->default("text");
            $table->string("event")->default("");
            $table->text("contents");
            $table->string("url");
            $table->string("image_url");
            $table->boolean("enabled")->default(false);
            $table->integer("manager_id")->default(0);
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
