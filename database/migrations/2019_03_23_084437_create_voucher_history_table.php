<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoucherHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher_history', function(Blueprint $table)
		{
			$table->integer('voucher_history_id', true);
			$table->integer('voucher_id');
			$table->integer('order_id');
			$table->decimal('amount', 15, 4);
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
		Schema::drop('voucher_history');
	}

}
