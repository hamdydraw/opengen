<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer', function(Blueprint $table)
		{
			$table->integer('customer_id', true);
			$table->integer('customer_group_id');
			$table->integer('store_id')->default(0);
			$table->integer('language_id');
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('telephone', 32);
			$table->string('fax', 32);
			$table->string('password', 40);
			$table->string('salt', 9);
			$table->text('cart', 65535)->nullable();
			$table->text('wishlist', 65535)->nullable();
			$table->boolean('newsletter')->default(0);
			$table->integer('address_id')->default(0);
			$table->text('custom_field', 65535);
			$table->string('ip', 40);
			$table->boolean('status');
			$table->boolean('safe');
			$table->text('token', 65535);
			$table->string('code', 40);
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
		Schema::drop('customer');
	}

}
