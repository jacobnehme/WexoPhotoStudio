<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name',
        'email',
        'password',
        'role_id',
    ];

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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsto(Role::class)->get()->first();
    }

    public function isCustomer(){
        return $this->role_id == Role::customer();
    }

    public function customer(){
        return $this->hasMany(Customer::class)->get()->first();
    }

    public function isPhotographer(){
        return $this->role_id == Role::photographer();
    }

    public function photographer(){
        return $this->hasMany(Photographer::class)->get()->first();
    }
}
