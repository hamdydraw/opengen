<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_activity', function(Blueprint $table)
		{
			$table->integer('customer_activity_id', true);
			$table->integer('customer_id');
			$table->string('key', 64);
			$table->text('data', 65535);
			$table->string('ip', 40);
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
		Schema::drop('customer_activity');
	}

}
