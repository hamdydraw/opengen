<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner_image', function(Blueprint $table)
		{
			$table->integer('banner_image_id', true);
			$table->integer('banner_id');
			$table->integer('language_id');
			$table->string('title', 64);
			$table->string('link');
			$table->string('image');
			$table->integer('sort_order')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banner_image');
	}

}
