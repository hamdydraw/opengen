<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('review', function(Blueprint $table)
		{
			$table->integer('review_id', true);
			$table->integer('product_id')->index('product_id');
			$table->integer('customer_id');
			$table->string('author', 64);
			$table->text('text', 65535);
			$table->integer('rating');
			$table->boolean('status')->default(0);
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
		Schema::drop('review');
	}

}
