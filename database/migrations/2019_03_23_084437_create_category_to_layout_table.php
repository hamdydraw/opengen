<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryToLayoutTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_to_layout', function(Blueprint $table)
		{
			$table->integer('category_id');
			$table->integer('store_id');
			$table->integer('layout_id');
			$table->primary(['category_id','store_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category_to_layout');
	}

}
