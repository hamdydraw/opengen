<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManufacturerToStoreTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manufacturer_to_store', function(Blueprint $table)
		{
			$table->integer('manufacturer_id');
			$table->integer('store_id');
			$table->primary(['manufacturer_id','store_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manufacturer_to_store');
	}

}
