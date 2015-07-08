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
			$table->integer('type_id')->unsigned()->default(0)->comment("商品分类ID");
			$table->decimal('shop_price')->default(0)->comment("店铺价");
            $table->decimal('cost')->default(0)->comment("成本");
			$table->decimal('market_price')->default(0)->comment("市场价");
			$table->string('goods_sn')->default('')->comment("商品编号");
			$table->integer('click_count')->default(0)->comment("点击次数");
			$table->integer('sold_count')->default(0)->comment("已售数量");
			$table->integer('goods_number')->default(0)->comment("库存数量");
            $table->integer('goods_weight')->defautl(0)->comment('商品重量 单位:g');
			$table->text('goods_desc')->default('')->comment("商品介绍");
			$table->integer('image_id')->default(0)->comment("主图ID地址:关联表ImageMd5");
			$table->integer('shipping_free')->default(0)->comment("包邮状态");
			$table->integer('is_on_sale')->default(1)->comment("销售状态");
			$table->integer('base_sold_count')->default(0)->comment("初始化已售数量");
			$table->boolean('is_delete')->default(false)->comment("删除状态");
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
		Schema::drop('goods');
	}

}
