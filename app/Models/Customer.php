<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Customer extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customer';
    protected $fillable = [
        'id', 'name','customer_group_id','email', 'telephone','fax','password','salt','cart',
        'wishlist','newsletter','address_id','custom_field','ip','status','safe','token','code'
    ];
 

}
