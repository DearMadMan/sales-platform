<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('consignee')->default('')->comment("收货人姓名");
			$table->string('province')->default('')->comment("省份");
			$table->string('city')->default('')->comment("市");
			$table->string('area')->default('')->comment("区");
			$table->string('address')->default('')->comment("详细地址");
			$table->string('phone')->default('')->comment("手机号");
			$table->string('zipcode')->default('')->comment("邮编");
			$table->integer('user_id')->unsigned()->default(0)->comment("用户ID");

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
		Schema::drop('addresses');
	}

}
