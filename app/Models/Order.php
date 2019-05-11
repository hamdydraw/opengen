<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Order extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'order';
    protected $fillable = [
        'id','invoice_no','invoice_prefix','merchant_id','customer_id','customer_name','pilot_id','payment_name','payment_company',
        'payment_address_1','payment_address_2','payment_city','payment_postcode','payment_country','payment_country_id','payment_zone',
        'payment_zone_id','payment_address_format','payment_custom_field','payment_method','payment_code','shipping_firstname','shipping_lastname','shipping_company',
        'shipping_address_1','shipping_address_2','shipping_city','shipping_postcode','shipping_country','shipping_country_id','shipping_zone',
        'shipping_zone_id','shipping_address_format','shipping_custom_field','shipping_method','shipping_code','comment','total','order_status_id',
        'affiliate_id','commission','marketing_id','tracking','language_id','currency_id','currency_code','currency_value','ip','forwarded_ip','user_agent'
    ];
    
    public function Merchant()
	{
		return $this->belongsTo('App\Models\merchant','merchant_id');
    }
    public function Customer()
	{
		return $this->belongsTo('App\Models\Customer','customer_id');
    }
    public function OrderStatus()
	{
		return $this->belongsTo('App\Models\OrderStatus','order_status_id');
	}

}
