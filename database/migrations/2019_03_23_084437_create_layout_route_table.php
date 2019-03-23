<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLayoutRouteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('layout_route', function(Blueprint $table)
		{
			$table->integer('layout_route_id', true);
			$table->integer('layout_id');
			$table->integer('store_id');
			$table->string('route', 64);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('layout_route');
	}

}
