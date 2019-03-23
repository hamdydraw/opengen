<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttributeGroupDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attribute_group_description', function(Blueprint $table)
		{
			$table->integer('attribute_group_id');
			$table->integer('language_id');
			$table->string('name', 64);
			$table->primary(['attribute_group_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attribute_group_description');
	}

}
