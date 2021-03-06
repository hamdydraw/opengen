<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Attribute extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'attribute';
    protected $fillable = [
        'id', 'attribute_group_id','sort_order','name_ar','name_en','merchant_id'
    ];
    public function Group()
	{
		return $this->belongsTo('App\Models\AttributeGroup','attribute_group_id');
	}

}
