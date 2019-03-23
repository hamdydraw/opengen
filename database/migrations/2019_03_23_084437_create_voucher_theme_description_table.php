<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoucherThemeDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher_theme_description', function(Blueprint $table)
		{
			$table->integer('voucher_theme_id');
			$table->integer('language_id');
			$table->string('name', 32);
			$table->primary(['voucher_theme_id','language_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('voucher_theme_description');
	}

}
