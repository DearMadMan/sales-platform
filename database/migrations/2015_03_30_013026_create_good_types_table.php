<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('good_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type_name')->default('')->comment("商品分类名称");
			$table->integer('parent_id')->unsigned()->default(0);
			$table->integer('manager_id')->unsigned()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('good_types');
	}

}
