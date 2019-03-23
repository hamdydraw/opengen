<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderRecurringTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_recurring_transaction', function(Blueprint $table)
		{
			$table->integer('order_recurring_transaction_id', true);
			$table->integer('order_recurring_id');
			$table->string('reference');
			$table->string('type');
			$table->decimal('amount', 10, 4);
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
		Schema::drop('order_recurring_transaction');
	}

}
