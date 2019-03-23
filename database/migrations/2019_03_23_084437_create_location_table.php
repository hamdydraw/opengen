<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('location', function(Blueprint $table)
		{
			$table->integer('location_id', true);
			$table->string('name', 32)->index('name');
			$table->text('address', 65535);
			$table->string('telephone', 32);
			$table->string('fax', 32);
			$table->string('geocode', 32);
			$table->string('image')->nullable();
			$table->text('open', 65535);
			$table->text('comment', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('location');
	}

}
