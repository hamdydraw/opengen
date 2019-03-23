<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function(Blueprint $table)
		{
			$table->integer('address_id', true);
			$table->integer('customer_id')->index('customer_id');
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('company', 40);
			$table->string('address_1', 128);
			$table->string('address_2', 128);
			$table->string('city', 128);
			$table->string('postcode', 10);
			$table->integer('country_id')->default(0);
			$table->integer('zone_id')->default(0);
			$table->text('custom_field', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('address');
	}

}
