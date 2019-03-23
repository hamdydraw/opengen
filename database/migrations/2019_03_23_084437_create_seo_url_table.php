<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeoUrlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seo_url', function(Blueprint $table)
		{
			$table->integer('seo_url_id', true);
			$table->integer('store_id');
			$table->integer('language_id');
			$table->string('query')->index('query');
			$table->string('keyword')->index('keyword');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seo_url');
	}

}
