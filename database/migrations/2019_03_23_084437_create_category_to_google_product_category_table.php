<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryToGoogleProductCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_to_google_product_category', function(Blueprint $table)
		{
			$table->string('google_product_category', 10);
			$table->integer('store_id')->default(0);
			$table->integer('category_id');
			$table->index(['category_id','store_id'], 'category_id_store_id');
			$table->primary(['google_product_category','store_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category_to_google_product_category');
	}

}
