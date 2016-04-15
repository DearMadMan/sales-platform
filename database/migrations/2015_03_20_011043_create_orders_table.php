<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->commit('用户id');
			$table->string('order_sn')->default('')->commit('订单编号');
			$table->integer('order_status')->default(0)->commit('订单状态: 0:正常, 1:已完成, 2: 已取消');
			$table->integer('pay_status')->default(0)->commit('支付状态： 0：正常， 1：已支付');
			$table->integer('shipping_status')->default(0)->commit('发货状态：0：正常， 1： 已发货');
			$table->decimal('goods_amount')->default(0)->commit('订单总金额');
			$table->decimal('shipping_amount')->default(0)->commit('运费金额');
			$table->string('pay_time')->default('')->commit('支付时间');
			$table->string('consignee')->default('')->commit('收件人');
			$table->string('city')->default('')->commit('市');
			$table->string('province')->default('')->commit('省');
			$table->string('area')->default('')->comment("区域");
			$table->string('phone')->default('')->commit('手机号');
			$table->string('address')->default('')->commit('详细地址');
			$table->integer('shipping_id')->unsigned()->default(0)->commit('快递方式id');
			$table->string('shipping_name')->default('')->commit('快递名称');
			$table->integer('pay_id')->unsigned()->default(0)->commit('支付方式id');
			$table->string('pay_name')->default('')->commit('支付方式名称');
			$table->decimal('pay_amount')->default(0)->commit('已支付金额');

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
		Schema::drop('orders');
	}

}
