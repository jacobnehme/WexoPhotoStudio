<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name_first',
        'name_last',
        'name_company',
        'address',
        'zip_code_id',
        'city', //TODO check if needed
    ];

    //Relations
    public function _user(){
        return $this->belongsTo(User::class);
    }

    public function _zipCode(){
        return $this->belongsTo(ZipCode::class);
    }

    //Objects
    public function user(){
        return $this->belongsTo(User::class)->get()->first();
    }

    public function zipCode(){
        return $this->belongsTo(ZipCode::class)->get()->first();
    }
}
