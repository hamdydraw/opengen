<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomFieldValueDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_field_value_description', function(Blueprint $table)
		{
			$table->integer('custom_field_value_id');
			$table->integer('language_id');
			$table->integer('custom_field_id');
			$table->string('name', 128);
			$table->primary(['custom_field_value_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_field_value_description');
	}

}
