<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerGroupDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_group_description', function(Blueprint $table)
		{
			$table->integer('customer_group_id');
			$table->integer('language_id');
			$table->string('name', 32);
			$table->text('description', 65535);
			$table->primary(['customer_group_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_group_description');
	}

}
