<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order', function(Blueprint $table)
		{
			$table->integer('order_id', true);
			$table->integer('invoice_no')->default(0);
			$table->string('invoice_prefix', 26);
			$table->integer('store_id')->default(0);
			$table->string('store_name', 64);
			$table->string('store_url');
			$table->integer('customer_id')->default(0);
			$table->integer('customer_group_id')->default(0);
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('telephone', 32);
			$table->string('fax', 32);
			$table->text('custom_field', 65535);
			$table->string('payment_firstname', 32);
			$table->string('payment_lastname', 32);
			$table->string('payment_company', 60);
			$table->string('payment_address_1', 128);
			$table->string('payment_address_2', 128);
			$table->string('payment_city', 128);
			$table->string('payment_postcode', 10);
			$table->string('payment_country', 128);
			$table->integer('payment_country_id');
			$table->string('payment_zone', 128);
			$table->integer('payment_zone_id');
			$table->text('payment_address_format', 65535);
			$table->text('payment_custom_field', 65535);
			$table->string('payment_method', 128);
			$table->string('payment_code', 128);
			$table->string('shipping_firstname', 32);
			$table->string('shipping_lastname', 32);
			$table->string('shipping_company', 40);
			$table->string('shipping_address_1', 128);
			$table->string('shipping_address_2', 128);
			$table->string('shipping_city', 128);
			$table->string('shipping_postcode', 10);
			$table->string('shipping_country', 128);
			$table->integer('shipping_country_id');
			$table->string('shipping_zone', 128);
			$table->integer('shipping_zone_id');
			$table->text('shipping_address_format', 65535);
			$table->text('shipping_custom_field', 65535);
			$table->string('shipping_method', 128);
			$table->string('shipping_code', 128);
			$table->text('comment', 65535);
			$table->decimal('total', 15, 4)->default(0.0000);
			$table->integer('order_status_id')->default(0);
			$table->integer('affiliate_id');
			$table->decimal('commission', 15, 4);
			$table->integer('marketing_id');
			$table->string('tracking', 64);
			$table->integer('language_id');
			$table->integer('currency_id');
			$table->string('currency_code', 3);
			$table->decimal('currency_value', 15, 8)->default(1.00000000);
			$table->string('ip', 40);
			$table->string('forwarded_ip', 40);
			$table->string('user_agent');
			$table->string('accept_language');
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
		Schema::drop('order');
	}

}
