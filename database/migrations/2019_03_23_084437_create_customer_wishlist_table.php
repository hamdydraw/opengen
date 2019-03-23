<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerWishlistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_wishlist', function(Blueprint $table)
		{
			$table->integer('customer_id');
			$table->integer('product_id');
			$table->dateTime('date_added');
			$table->primary(['customer_id','product_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_wishlist');
	}

}
