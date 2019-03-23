<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTotalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_total', function(Blueprint $table)
		{
			$table->integer('order_total_id', true);
			$table->integer('order_id')->index('order_id');
			$table->string('code', 32);
			$table->string('title');
			$table->decimal('value', 15, 4)->default(0.0000);
			$table->integer('sort_order');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_total');
	}

}
