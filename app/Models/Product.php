<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Product extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $table = 'product';
    protected $fillable = [
        'id','name_ar','name_en','photo','model','description','code','price','tax_id','quantity',
        'minimum','stock_status_id','r_shipping','length','width','heigth','weight','weight_class_id',
        'length_class_id','sort_order','subtract','status', 'tag', 'meta_title','meta_description','meta_keyword'

    ];
}
