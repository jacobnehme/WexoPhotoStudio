<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photographer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_no',
    ];

    //Relations
    public function _user(){
        return $this->belongsTo(User::class);
    }

    //Objects
    public function user(){
        return $this->belongsTo(User::class)->get()->first();
    }
}
