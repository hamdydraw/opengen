<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInformationToLayoutTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('information_to_layout', function(Blueprint $table)
		{
			$table->integer('information_id');
			$table->integer('store_id');
			$table->integer('layout_id');
			$table->primary(['information_id','store_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('information_to_layout');
	}

}
