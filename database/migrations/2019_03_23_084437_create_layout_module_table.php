<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLayoutModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('layout_module', function(Blueprint $table)
		{
			$table->integer('layout_module_id', true);
			$table->integer('layout_id');
			$table->string('code', 64);
			$table->string('position', 14);
			$table->integer('sort_order');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('layout_module');
	}

}
