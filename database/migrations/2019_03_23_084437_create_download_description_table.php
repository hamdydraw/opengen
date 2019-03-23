<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDownloadDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('download_description', function(Blueprint $table)
		{
			$table->integer('download_id');
			$table->integer('language_id');
			$table->string('name', 64);
			$table->primary(['download_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('download_description');
	}

}
