<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatKeywordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_keywords', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key')->default('')->comment("关键字");
			$table->integer('type')->default(0)->comment("文本或图文");
			$table->text('contents');
			$table->integer('count')->default(0);
			$table->boolean('status')->default(true);
			$table->integer('manager_id')->unsigned()->default(0);

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
		Schema::drop('wechat_keywords');
	}

}
