<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerSearchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_search', function(Blueprint $table)
		{
			$table->integer('customer_search_id', true);
			$table->integer('store_id');
			$table->integer('language_id');
			$table->integer('customer_id');
			$table->string('keyword');
			$table->integer('category_id')->nullable();
			$table->boolean('sub_category');
			$table->boolean('description');
			$table->integer('products');
			$table->string('ip', 40);
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
		Schema::drop('customer_search');
	}

}
