<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionValueDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_value_description', function(Blueprint $table)
		{
			$table->integer('option_value_id');
			$table->integer('language_id');
			$table->integer('option_id');
			$table->string('name', 128);
			$table->primary(['option_value_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('option_value_description');
	}

}
