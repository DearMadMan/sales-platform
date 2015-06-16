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
			$table->integer('user_id')->unsigned()->default(0);
			$table->string('order_sn')->default('');
			$table->integer('order_status')->default(0);
			$table->integer('pay_status')->default(0);
			$table->integer('shipping_status')->default(0);
			$table->decimal('goods_amount')->default(0);
			$table->decimal('shipping_amount')->default(0);
			$table->string('pay_time')->default('');
			$table->string('consignee')->default('');
			$table->string('city')->default('');
			$table->string('province')->default('');
			$table->string('area')->default('')->comment("区域");
			$table->string('phone')->default('');
			$table->string('address')->default('');
			$table->integer('shipping_id')->unsigned()->default(0);
			$table->string('shipping_name')->default('');
			$table->integer('pay_id')->unsigned()->default(0);
			$table->string('pay_name')->default('');
			$table->decimal('pay_amount')->default(0);

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
