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
			$table->integer('scene_id')->unsigned()->default(0);
			$table->string('action_name')->default('');
			$table->string('scene_str')->default('');
			$table->string('ticket')->default('');
			$table->string('qr_path')->default('');
			$table->integer('subscribe')->default(0);
			$table->integer('scan')->default(0);
			$table->integer('subset')->default(0);
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
