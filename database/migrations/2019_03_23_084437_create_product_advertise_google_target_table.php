<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAdvertiseGoogleTargetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_advertise_google_target', function(Blueprint $table)
		{
			$table->integer('product_id');
			$table->integer('store_id')->default(0);
			$table->integer('advertise_google_target_id')->unsigned();
			$table->primary(['product_id','advertise_google_target_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_advertise_google_target');
	}

}
