<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZoneToGeoZoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zone_to_geo_zone', function(Blueprint $table)
		{
			$table->integer('zone_to_geo_zone_id', true);
			$table->integer('country_id');
			$table->integer('zone_id')->default(0);
			$table->integer('geo_zone_id');
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
		Schema::drop('zone_to_geo_zone');
	}

}
