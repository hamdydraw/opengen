<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_status', function(Blueprint $table)
		{
			$table->integer('return_status_id', true);
			$table->integer('language_id')->default(0);
			$table->string('name', 32);
			$table->primary(['return_status_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return_status');
	}

}
