<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class ProductAttribute extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps = false;
    protected $table = 'product_attribute';
    protected $fillable = [
        'id','product_id', 'attribute_id','language_id','text'
    ];
 

}
