<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerRewardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_reward', function(Blueprint $table)
		{
			$table->integer('customer_reward_id', true);
			$table->integer('customer_id')->default(0);
			$table->integer('order_id')->default(0);
			$table->text('description', 65535);
			$table->integer('points')->default(0);
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
		Schema::drop('customer_reward');
	}

}
