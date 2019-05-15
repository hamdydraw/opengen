<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Evaluation extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'evaluations';
    protected $fillable = [
        'id', 'from_user_id','to_user_id','merchant_id','text', 'rating','status'
    ];
    public function FromUser()
	{
        return $this->belongsTo('App\User','from_user_id');
	}
    public function Merchant()
	{
        return $this->belongsTo('App\Models\Merchant','merchant_id');
	}
}
