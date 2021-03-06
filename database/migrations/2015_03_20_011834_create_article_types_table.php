<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type_name')->default('')->comment("文章类型名称");
			$table->string('desc')->default('')->comment("简要描述");
			$table->integer('parent_id')->unsigned()->default(0);
			$table->integer('index')->default(0);
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
		Schema::drop('article_types');
	}

}
