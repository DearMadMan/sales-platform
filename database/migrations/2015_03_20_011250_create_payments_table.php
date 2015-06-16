<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('pay_code')->default('')->comment("支付方式代码");
			$table->string('pay_name')->default('')->comment("支付方式名称");
			$table->decimal('pay_fee')->default(0)->comment("支付费率");
			$table->text('pay_desc')->comment("支付方式描述信息");
			$table->text('pay_config')->comment("支付方式配置信息");
			$table->boolean('enabled')->default(false)->comment("启用状态");
			$table->boolean('is_online')->default(false)->comment("是否在线支付");
			$table->boolean('is_cod')->default(false)->comment("是否支持货到付款");
			$table->integer('manager_id')->unsigned()->default(0)->comment("所属者ID");

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
		Schema::drop('payments');
	}

}
