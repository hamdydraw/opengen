<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_history', function(Blueprint $table)
		{
			$table->integer('coupon_history_id', true);
			$table->integer('coupon_id');
			$table->integer('order_id');
			$table->integer('customer_id');
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
		Schema::drop('coupon_history');
	}

}
