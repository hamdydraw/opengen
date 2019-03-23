<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductOptionValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_option_value', function(Blueprint $table)
		{
			$table->integer('product_option_value_id', true);
			$table->integer('product_option_id');
			$table->integer('product_id');
			$table->integer('option_id');
			$table->integer('option_value_id');
			$table->integer('quantity');
			$table->boolean('subtract');
			$table->decimal('price', 15, 4);
			$table->string('price_prefix', 1);
			$table->integer('points');
			$table->string('points_prefix', 1);
			$table->decimal('weight', 15, 8);
			$table->string('weight_prefix', 1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_option_value');
	}

}
