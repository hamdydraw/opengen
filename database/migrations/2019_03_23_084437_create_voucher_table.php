<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoucherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher', function(Blueprint $table)
		{
			$table->integer('voucher_id', true);
			$table->integer('order_id');
			$table->string('code', 10);
			$table->string('from_name', 64);
			$table->string('from_email', 96);
			$table->string('to_name', 64);
			$table->string('to_email', 96);
			$table->integer('voucher_theme_id');
			$table->text('message', 65535);
			$table->decimal('amount', 15, 4);
			$table->boolean('status');
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
		Schema::drop('voucher');
	}

}
