<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart', function(Blueprint $table)
		{
			$table->increments('cart_id');
			$table->integer('api_id');
			$table->integer('customer_id');
			$table->string('session_id', 32);
			$table->integer('product_id');
			$table->integer('recurring_id');
			$table->text('option', 65535);
			$table->integer('quantity');
			$table->dateTime('date_added');
			$table->index(['api_id','customer_id','session_id','product_id','recurring_id'], 'cart_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cart');
	}

}
