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
			$table->decimal('pay_fee')->default(0);
			$table->text('pay_desc');
			$table->text('pay_config');
			$table->boolean('enabled')->default(false);
			$table->boolean('is_online')->default(false);
			$table->boolean('is_cod')->default(false);
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
		Schema::drop('payments');
	}

}
