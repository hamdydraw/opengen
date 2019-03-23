<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertiseGoogleTargetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertise_google_target', function(Blueprint $table)
		{
			$table->integer('advertise_google_target_id')->unsigned()->primary();
			$table->integer('store_id')->default(0)->index('store_id');
			$table->string('campaign_name')->default('');
			$table->string('country', 2)->default('');
			$table->decimal('budget', 15, 4)->default(0.0000);
			$table->text('feeds', 65535);
			$table->enum('status', array('paused','active'))->default('paused');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('advertise_google_target');
	}

}
