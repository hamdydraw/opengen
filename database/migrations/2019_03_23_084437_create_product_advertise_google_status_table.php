<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAdvertiseGoogleStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_advertise_google_status', function(Blueprint $table)
		{
			$table->integer('product_id')->default(0);
			$table->integer('store_id')->default(0);
			$table->string('product_variation_id', 64)->default('');
			$table->text('destination_statuses', 65535);
			$table->text('data_quality_issues', 65535);
			$table->text('item_level_issues', 65535);
			$table->integer('google_expiration_date')->default(0);
			$table->primary(['product_id','store_id','product_variation_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_advertise_google_status');
	}

}
