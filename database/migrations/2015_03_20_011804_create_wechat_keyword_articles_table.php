<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatKeywordArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_keyword_articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('keyword_id')->unsigned()->default(0);
			$table->integer('article_id')->unsigned()->default(0);
			$table->integer('index')->unsigned()->default(0);
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
		Schema::drop('wechat_keyword_articles');
	}

}
