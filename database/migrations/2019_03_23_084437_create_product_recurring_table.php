<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductRecurringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_recurring', function(Blueprint $table)
		{
			$table->integer('product_id');
			$table->integer('recurring_id');
			$table->integer('customer_group_id');
			$table->primary(['product_id','recurring_id','customer_group_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_recurring');
	}

}
