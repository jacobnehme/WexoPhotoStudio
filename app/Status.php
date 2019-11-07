<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public static function statusId($title){
        return Status::where('title', $title)->first()->id;
    }

    public static function pending(){
        return Status::where('title', 'pending')->first()->id;
    }

    public static function rejected(){
        return Status::where('title', 'rejected')->first()->id;
    }

    public static function approved(){
        return Status::where('title', 'approved')->first()->id;
    }
}
