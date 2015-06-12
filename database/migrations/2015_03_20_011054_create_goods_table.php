<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('goods_name')->default('');
			$table->integer('catgory_id')->unsigned()->default(0);
			$table->decimal('shop_price')->default(0);
			$table->decimal('market_price')->default(0);
			$table->string('goods_sn')->default('');
			$table->integer('click_count')->default(0);
			$table->integer('sold_count')->default(0);
			$table->integer('goods_number')->default(0);
			$table->text('goods_desc')->default('');
			$table->string('goods_thumb')->default('');
			$table->string('goods_origin')->default('');
			$table->string('goods_img')->default('');
			$table->integer('shipping_free')->default(0);
			$table->integer('is_on_sale')->default(1);
			$table->integer('base_sold_count')->default(0);
			$table->boolean('is_delete')->default(false);
			$table->integer('manager_id')->unsigned()->default(0);

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
		Schema::drop('goods');
	}

}
