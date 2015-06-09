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
			$table->string('pay_code')->default('');
			$table->string('pay_name')->default('');
			$table->decimal('pay_fee')->default('');
			$table->text('pay_desc')->default('');
			$table->text('pay_config')->default('');
			$table->boolean('enabled')->default('');
			$table->boolean('is_online')->default('');
			$table->boolean('is_cod')->default('');
			$table->integer('manager_id')->unsigned()->default('');

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
