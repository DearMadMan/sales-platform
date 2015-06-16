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
			$table->integer('user_type_id')->unsigned()->comment("用户类型");
			$table->string('name')->default('')->comment("用户名");
			$table->string('email')->unique()->comment("邮箱");
			$table->string('password', 60)->comment("密码");
			$table->string('nick_name')->default('')->comment("昵称");
			$table->string('open_id')->default('')->comment("OpenId");
			$table->string('access_token')->default('')->comment("access_token");
			$table->string('image_url')->default('')->comment("头像地址");
			$table->string('expires_in')->default('')->comment("过期时间");
			$table->integer('subscribe_status')->default(0)->comment("关注状态");
			$table->string('subscribe_time')->default('')->comment("关注时间");
			$table->string('unsubscribe_time')->default('')->comment("取消关注时间");
			$table->string('sex')->default('')->comment("性别");
			$table->string('city')->default('')->comment("城市");
			$table->string('country')->default('')->comment("国家");
			$table->string('province')->default('')->comment("省份");
			$table->integer('parent_id')->default(0)->comment("推荐者ID");
			$table->string('lang')->default('')->comment("语言");
			$table->string('privilege')->default('')->comment("privilege");
			$table->string('unionid')->default('');
			$table->integer('address_id')->unsigned()->default(0)->comment("详细地址ID");
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
