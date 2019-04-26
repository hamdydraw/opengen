<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class ProductOptionValue extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_option_value';
    protected $fillable = [
        'id','product_option_id', 'product_id','option_id','option_value_id','quantity','subtract',
        'price','price_prefix','points','points_prefix','weight','weight_prefix'
    ];
 

}
