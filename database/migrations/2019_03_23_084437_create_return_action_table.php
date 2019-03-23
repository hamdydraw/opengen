<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnActionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_action', function(Blueprint $table)
		{
			$table->integer('return_action_id', true);
			$table->integer('language_id')->default(0);
			$table->string('name', 64);
			$table->primary(['return_action_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return_action');
	}

}
