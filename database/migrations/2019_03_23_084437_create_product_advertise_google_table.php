<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAdvertiseGoogleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_advertise_google', function(Blueprint $table)
		{
			$table->integer('product_advertise_google_id')->unsigned()->primary();
			$table->integer('product_id')->nullable();
			$table->integer('store_id')->default(0);
			$table->boolean('has_issues')->nullable();
			$table->enum('destination_status', array('pending','approved','disapproved'))->default('pending');
			$table->integer('impressions')->default(0);
			$table->integer('clicks')->default(0);
			$table->integer('conversions')->default(0);
			$table->decimal('cost', 15, 4)->default(0.0000);
			$table->decimal('conversion_value', 15, 4)->default(0.0000);
			$table->string('google_product_category', 10)->nullable();
			$table->enum('condition', array('new','refurbished','used'))->nullable();
			$table->boolean('adult')->nullable();
			$table->integer('multipack')->nullable();
			$table->boolean('is_bundle')->nullable();
			$table->enum('age_group', array('newborn','infant','toddler','kids','adult'))->nullable();
			$table->integer('color')->nullable();
			$table->enum('gender', array('male','female','unisex'))->nullable();
			$table->enum('size_type', array('regular','petite','plus','big and tall','maternity'))->nullable();
			$table->enum('size_system', array('AU','BR','CN','DE','EU','FR','IT','JP','MEX','UK','US'))->nullable();
			$table->integer('size')->nullable();
			$table->boolean('is_modified')->default(0);
			$table->unique(['product_id','store_id'], 'product_id_store_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_advertise_google');
	}

}
