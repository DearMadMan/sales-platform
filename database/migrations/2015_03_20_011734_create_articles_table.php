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
			$table->integer('type_id')->unsigned()->default(0);
			$table->string('title')->default('');
			$table->text('content');
			$table->boolean('is_show')->default(true);
			$table->string('out_link')->default('');
			$table->string('desciption')->default('');
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
