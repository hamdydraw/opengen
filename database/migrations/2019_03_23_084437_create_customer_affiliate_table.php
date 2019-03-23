<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerAffiliateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_affiliate', function(Blueprint $table)
		{
			$table->integer('customer_id')->primary();
			$table->string('company', 40);
			$table->string('website');
			$table->string('tracking', 64);
			$table->decimal('commission', 4)->default(0.00);
			$table->string('tax', 64);
			$table->string('payment', 6);
			$table->string('cheque', 100);
			$table->string('paypal', 64);
			$table->string('bank_name', 64);
			$table->string('bank_branch_number', 64);
			$table->string('bank_swift_code', 64);
			$table->string('bank_account_name', 64);
			$table->string('bank_account_number', 64);
			$table->text('custom_field', 65535);
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
		Schema::drop('customer_affiliate');
	}

}
