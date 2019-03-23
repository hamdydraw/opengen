<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderShipmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_shipment', function(Blueprint $table)
		{
			$table->integer('order_shipment_id', true);
			$table->integer('order_id');
			$table->dateTime('date_added');
			$table->string('shipping_courier_id')->default('');
			$table->string('tracking_number')->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_shipment');
	}

}
