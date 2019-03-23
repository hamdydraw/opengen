<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomFieldCustomerGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_field_customer_group', function(Blueprint $table)
		{
			$table->integer('custom_field_id');
			$table->integer('customer_group_id');
			$table->boolean('required');
			$table->primary(['custom_field_id','customer_group_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_field_customer_group');
	}

}
