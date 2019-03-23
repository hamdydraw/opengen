<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingCourierTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping_courier', function(Blueprint $table)
		{
			$table->integer('shipping_courier_id')->primary();
			$table->string('shipping_courier_code')->default('');
			$table->string('shipping_courier_name')->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shipping_courier');
	}

}
