<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class LengthclassDescription extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'length_class_description';
    public $timestamps = false;

    protected $fillable = [
        'length_class_id', 'language_id', 'title','code'
    ];
    //protected $primaryKey = ['category_id', 'language_id'];

    
	public function Lengthclass()
	{
		return $this->belongsTo('App\Models\Lengthclass','length_class_id');
	}
 
}
