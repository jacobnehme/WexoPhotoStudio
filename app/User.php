<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use mysql_xdevapi\Exception;

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

    //Get customer subclass
    public function customer(){
        if ($this->isRole(Role::customer())){
            return $this->hasMany(Customer::class)->get()->first();
        }
        else{
            throw new Exception('This User is not a Customer.');
        }
    }

    //Get photographer subclass
    public function photographer(){
        if ($this->isRole(Role::photographer())){
            return $this->hasMany(Photographer::class)->get()->first();
        }
        else{
            throw new Exception('This User is not a Photographer.');
        }
    }

    //TODO Replace specific role methods
    public function isRole($role){
        return $this->role_id == $role;
    }

    public function isCustomer(){
        return $this->role_id == Role::customer();
    }

    public function isPhotographer(){
        return $this->role_id == Role::photographer();

    }

    //TODO possible get role class
    public function getRoleClass(){
        //return $this->hasMany($this->Role())->get()->first();
    }
}
