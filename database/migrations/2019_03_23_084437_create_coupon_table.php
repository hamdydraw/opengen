<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon', function(Blueprint $table)
		{
			$table->integer('coupon_id', true);
			$table->string('name', 128);
			$table->string('code', 20);
			$table->char('type', 1);
			$table->decimal('discount', 15, 4);
			$table->boolean('logged');
			$table->boolean('shipping');
			$table->decimal('total', 15, 4);
			$table->date('date_start')->default('0000-00-00');
			$table->date('date_end')->default('0000-00-00');
			$table->integer('uses_total');
			$table->string('uses_customer', 11);
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
		Schema::drop('coupon');
	}

}
