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

    //Relations
    public function _role()
    {
        return $this->belongsto(Role::class);
    }

    public function _customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function _photographer()
    {
        return $this->hasMany(Photographer::class);
    }

    //Objects
    public function role()
    {
        return $this->belongsto(Role::class)->get()->first();
    }

    public function customer()
    {
        return $this->hasMany(Customer::class)->get()->first();
    }

    public function photographer()
    {
        return $this->hasMany(Photographer::class)->get()->first();
    }

    //Methods
    public function isRole($role)
    {
        return $this->role_id == Role::roleId($role);
    }

    public function setRole($role){
        $this->update(['role_id' => Role::roleId($role)]);
    }
}
