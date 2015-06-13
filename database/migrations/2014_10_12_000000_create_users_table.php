<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_type_id')->unsigned();
			$table->string('name')->default('');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('nick_name')->default('');
			$table->string('open_id')->default('');
			$table->string('access_token')->default('');
			$table->string('image_url')->default('');
			$table->string('expires_in')->default('');
			$table->integer('subscribe_status')->default(0);
			$table->string('subscribe_time')->default('');
			$table->string('unsubscribe_time')->default('');
			$table->string('sex')->default('');
			$table->string('city')->default('');
			$table->string('country')->default('');
			$table->string('province')->default('');
			$table->integer('parent_id')->default(0);
			$table->string('lang')->default('');
			$table->string('privilege')->default('');
			$table->string('unionid')->default('');
			$table->integer('address_id')->unsigned()->default(0);
			$table->integer('manager_id')->unsigned()->default(0);

			$table->rememberToken();
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

		Schema::drop('users');
	}


}
