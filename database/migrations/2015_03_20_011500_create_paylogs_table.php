<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaylogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paylogs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->default(0);
			$table->string('pay_time')->default('');
			$table->decimal('order_amount')->default(0);
			$table->boolean('is_paid')->default(false);
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
		Schema::drop('paylogs');
	}

}
