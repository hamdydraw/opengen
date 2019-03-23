<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnReasonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_reason', function(Blueprint $table)
		{
			$table->integer('return_reason_id', true);
			$table->integer('language_id')->default(0);
			$table->string('name', 128);
			$table->primary(['return_reason_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return_reason');
	}

}
