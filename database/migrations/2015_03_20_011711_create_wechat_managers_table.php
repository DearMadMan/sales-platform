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
			$table->string('name')->default('');
			$table->integer('user_id')->unsigned()->default(0);
			$table->string('wechat')->unique()->default('');
			$table->string('phone')->default('');
			$table->string('email')->unique()->default('');
			$table->string('qq')->default('');
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
