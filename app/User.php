<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UsesUuid;
use Auth;
use App\Role;
use App\Otp;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo_profile'
    ];

    protected function get_user_role_id(){
        $role = \App\Role::where('name','User')->first();
        return $role->id;
    }
    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function otp(){
        return $this->belongsTo('App\Otp');
    }

    // public static function boot(){
    //     parent::boot();

    //     static::creating(function ($model){
    //         $model->role_id = $model->get_user_role_id();
    //     });

    //     static::created(function($model){
    //         $model->generate_otp_code();
    //     });
    // }

    public function isEmailVerified(){
        if(Auth::user()->email_verified_at !== null && Auth::user()->password !== null){
            return true;
        }
        return false;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function getCreatedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    // }
    
    // public function getUpdatedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    // }
    
    public function generate_otp_code(){
        do{
            $random = mt_rand(100000,999999);
            $check = otp::where('otp',$random)->first();
        }while($check);

        $now = Carbon::now();

        $otp = otp::updateOrCreate(
            ['user_id' => $this->id],
            ['otp' => $random, 'valid_until' => $now->addMinutes(5)]
        );

    
    }    
}
