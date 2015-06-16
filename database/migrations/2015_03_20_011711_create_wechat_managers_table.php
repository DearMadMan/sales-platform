<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatManagersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_managers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('')->comment("姓名");
			$table->integer('user_id')->unsigned()->default(0);
			$table->string('wechat')->unique()->default('')->comment("微信名");
			$table->string('phone')->default('')->comment("手机号");
			$table->string('email')->unique()->default('')->comment("邮箱");
			$table->string('qq')->default('')->comment("QQ");
			//$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wechat_managers');
	}

}
