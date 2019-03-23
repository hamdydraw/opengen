<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxRuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_rule', function(Blueprint $table)
		{
			$table->integer('tax_rule_id', true);
			$table->integer('tax_class_id');
			$table->integer('tax_rate_id');
			$table->string('based', 10);
			$table->integer('priority')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tax_rule');
	}

}
