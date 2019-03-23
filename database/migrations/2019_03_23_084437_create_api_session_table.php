<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApiSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('api_session', function(Blueprint $table)
		{
			$table->integer('api_session_id', true);
			$table->integer('api_id');
			$table->string('session_id', 32);
			$table->string('ip', 40);
			$table->dateTime('date_added');
			$table->dateTime('date_modified');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('api_session');
	}

}
