<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class OrderProduct extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps = false;
    protected $table = 'order_product';
    protected $fillable = [
        'id','order_id','product_id','name','model','quantity','price','total','tax','reward'
    ];
 

}
