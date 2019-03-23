<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return', function(Blueprint $table)
		{
			$table->integer('return_id', true);
			$table->integer('order_id');
			$table->integer('product_id');
			$table->integer('customer_id');
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('telephone', 32);
			$table->string('product');
			$table->string('model', 64);
			$table->integer('quantity');
			$table->boolean('opened');
			$table->integer('return_reason_id');
			$table->integer('return_action_id');
			$table->integer('return_status_id');
			$table->text('comment', 65535)->nullable();
			$table->date('date_ordered')->default('0000-00-00');
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
		Schema::drop('return');
	}

}
