<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTranslationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('translation', function(Blueprint $table)
		{
			$table->integer('translation_id', true);
			$table->integer('store_id');
			$table->integer('language_id');
			$table->string('route', 64);
			$table->string('key', 64);
			$table->text('value', 65535);
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
		Schema::drop('translation');
	}

}
