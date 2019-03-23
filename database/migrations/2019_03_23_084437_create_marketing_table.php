<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarketingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('marketing', function(Blueprint $table)
		{
			$table->integer('marketing_id', true);
			$table->string('name', 32);
			$table->text('description', 65535);
			$table->string('code', 64);
			$table->integer('clicks')->default(0);
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
		Schema::drop('marketing');
	}

}
