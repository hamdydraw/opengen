<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('theme', function(Blueprint $table)
		{
			$table->integer('theme_id', true);
			$table->integer('store_id');
			$table->string('theme', 64);
			$table->string('route', 64);
			$table->text('code', 16777215);
			$table->dateTime('date_added');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('theme');
	}

}
