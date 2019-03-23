<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInformationDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('information_description', function(Blueprint $table)
		{
			$table->integer('information_id');
			$table->integer('language_id');
			$table->string('title', 64);
			$table->text('description', 16777215);
			$table->string('meta_title');
			$table->string('meta_description');
			$table->string('meta_keyword');
			$table->primary(['information_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('information_description');
	}

}
