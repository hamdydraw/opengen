<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_image', function(Blueprint $table)
		{
			$table->integer('product_image_id', true);
			$table->integer('product_id')->index('product_id');
			$table->string('image')->nullable();
			$table->integer('sort_order')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_image');
	}

}
