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

    public static function customer()
    {
        return Status::where('title', 'customer')->first()->id;
    }

    public static function photographer()
    {
        return Status::where('title', 'photographer')->first()->id;
    }

    public static function getRoleId($role)
    {
        return Status::where('title', $role)->first()->id;
    }
}
