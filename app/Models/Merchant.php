<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Merchant extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'merchant';
    protected $fillable = [
        'id', 'name_ar', 'name_en','merchant_type_id','city_id','country_id','location','photo','owner_photo',
        'mobile','mobile_type_id','haveHW','haveSW'

    ];

    public function MerchantType()
	{
        return $this->belongsTo('App\Models\MerchantType');
	}
    public function MobileType()
	{
        return $this->belongsTo('App\Models\MobileType');
	}
    
    
 

}
