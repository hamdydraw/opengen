<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_attribute', function(Blueprint $table)
		{
			$table->integer('product_id');
			$table->integer('attribute_id');
			$table->integer('language_id');
			$table->text('text', 65535);
			$table->primary(['product_id','attribute_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_attribute');
	}

}
