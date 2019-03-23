<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilterDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('filter_description', function(Blueprint $table)
		{
			$table->integer('filter_id');
			$table->integer('language_id');
			$table->integer('filter_group_id');
			$table->string('name', 64);
			$table->primary(['filter_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('filter_description');
	}

}
