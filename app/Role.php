<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public static function roleId($role)
    {
        return Role::where('title', $role)->first()->id;
    }

    public static function admin()
    {
        return Role::where('title', 'admin')->first()->id;
    }

    public static function photographer()
    {
        return Role::where('title', 'photographer')->first()->id;
    }

    public static function customer()
    {
        return Role::where('title', 'customer')->first()->id;
    }
}
