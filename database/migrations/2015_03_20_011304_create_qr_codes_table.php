<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQrCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('qr_codes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0);
			$table->integer('scene_id')->unsigned()->default(0)->comment("场景ID");
			$table->string('action_name')->default('')->comment("行为名称");
			$table->string('scene_str')->default('');
			$table->string('ticket')->default('');
			$table->string('qr_path')->default('')->comment("二维码地址");
			$table->integer('subscribe')->default(0)->comment("扫码关注者数量");
			$table->integer('scan')->default(0)->comment("扫描次数");
			$table->integer('subset')->default(0)->comment("当前推荐者ID");
			$table->string('fixed_path')->default('');

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
		Schema::drop('qr_codes');
	}

}
