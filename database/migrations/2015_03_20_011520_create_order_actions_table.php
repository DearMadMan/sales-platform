<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_actions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->default(0);
			$table->integer('user_id')->unsigned()->default(0);
			$table->integer('order_status')->default(0)->comment("订单状态");
			$table->integer('shipping_status')->default(0)->comment("货运状态");
			$table->integer('pay_status')->default(0)->comment("支付状态");
			$table->string('note')->default('')->comment("备注");

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
		Schema::drop('order_actions');
	}

}
