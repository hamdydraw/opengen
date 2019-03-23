<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderRecurringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_recurring', function(Blueprint $table)
		{
			$table->integer('order_recurring_id', true);
			$table->integer('order_id');
			$table->string('reference');
			$table->integer('product_id');
			$table->string('product_name');
			$table->integer('product_quantity');
			$table->integer('recurring_id');
			$table->string('recurring_name');
			$table->string('recurring_description');
			$table->string('recurring_frequency', 25);
			$table->smallInteger('recurring_cycle');
			$table->smallInteger('recurring_duration');
			$table->decimal('recurring_price', 10, 4);
			$table->boolean('trial');
			$table->string('trial_frequency', 25);
			$table->smallInteger('trial_cycle');
			$table->smallInteger('trial_duration');
			$table->decimal('trial_price', 10, 4);
			$table->boolean('status');
			$table->dateTime('date_added');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_recurring');
	}

}
