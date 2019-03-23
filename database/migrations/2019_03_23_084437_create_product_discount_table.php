<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductDiscountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_discount', function(Blueprint $table)
		{
			$table->integer('product_discount_id', true);
			$table->integer('product_id')->index('product_id');
			$table->integer('customer_group_id');
			$table->integer('quantity')->default(0);
			$table->integer('priority')->default(1);
			$table->decimal('price', 15, 4)->default(0.0000);
			$table->date('date_start')->default('0000-00-00');
			$table->date('date_end')->default('0000-00-00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_discount');
	}

}
