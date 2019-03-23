<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_history', function(Blueprint $table)
		{
			$table->integer('order_history_id', true);
			$table->integer('order_id');
			$table->integer('order_status_id');
			$table->boolean('notify')->default(0);
			$table->text('comment', 65535);
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
		Schema::drop('order_history');
	}

}
