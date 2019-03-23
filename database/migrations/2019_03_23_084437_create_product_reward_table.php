<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductRewardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_reward', function(Blueprint $table)
		{
			$table->integer('product_reward_id', true);
			$table->integer('product_id')->default(0);
			$table->integer('customer_group_id')->default(0);
			$table->integer('points')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_reward');
	}

}
