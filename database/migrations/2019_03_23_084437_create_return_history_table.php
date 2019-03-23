<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_history', function(Blueprint $table)
		{
			$table->integer('return_history_id', true);
			$table->integer('return_id');
			$table->integer('return_status_id');
			$table->boolean('notify');
			$table->text('comment', 65535);
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
		Schema::drop('return_history');
	}

}
