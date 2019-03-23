<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_rate', function(Blueprint $table)
		{
			$table->integer('tax_rate_id', true);
			$table->integer('geo_zone_id')->default(0);
			$table->string('name', 32);
			$table->decimal('rate', 15, 4)->default(0.0000);
			$table->char('type', 1);
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
		Schema::drop('tax_rate');
	}

}
