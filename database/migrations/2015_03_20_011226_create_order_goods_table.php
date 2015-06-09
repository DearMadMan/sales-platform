<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_goods', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->default(0);
			$table->integer('goods_id')->unsigned()->default(0);
			$table->string('goods_name')->default('');
			$table->string('goods_sn')->default('');
			$table->integer('goods_number')->default(0);
			$table->string('market_price')->default('');
			$table->string('goods_price')->default('');

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
		Schema::drop('order_goods');
	}

}
