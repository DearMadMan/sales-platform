<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_menus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('menu_type')->default('')->comment("菜单类型");
			$table->integer('parent_id')->unsigned()->default(0);
			$table->string('name')->default('')->comment("标题");
			$table->string('value')->default('')->comment("值");
			$table->integer('index')->default(0)->comment("排序");
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
		Schema::drop('wechat_menus');
	}

}
