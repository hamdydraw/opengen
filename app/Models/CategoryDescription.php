<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class CategoryDescription extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'category_description';
    protected $fillable = [
        'category_id', 'language_id', 'name','description','meta_title','meta_description','meta_keyword'
    ];
    //protected $primaryKey = ['category_id', 'language_id'];

    
	public function Category()
	{
		return $this->belongsTo('App\Models\Category','category_id');
	}
 
}
