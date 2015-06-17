<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type_id')->unsigned()->default(0)->comment("文章分类");
			$table->string('title')->default('')->comment("标题");
			$table->string('pic_url')->default('')->comment("文章图片链接");
			$table->text('content')->comment("文章内容");
			$table->boolean('is_show')->default(true)->comment("显示状态");
			$table->string('out_link')->default('')->comment("导向链接");
			$table->string('desciption')->default('')->comment("简要描述");
			$table->integer('manager_id')->unsigned()->default(0);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
