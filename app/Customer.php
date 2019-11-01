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
        'zip_code',
        'city',
    ];

    public function zipCode($id){
        //TODO fix: probably because "zip_code" is not "zip_code_id"
        //return $this->belongsTo(ZipCode::class);
        return ZipCode::where('id', $id)->get()->first();
    }
}
