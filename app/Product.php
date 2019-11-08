<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'barcode',
        'title',
        'description',
    ];

    //Relations
    public function _photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function _orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    //Objects
    public function photos()
    {
        return $this->hasMany(Photo::class)->get();
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class)->get();
    }

    //Get OrderLines with conditions
    public function preApproval(){
        //
    }
}
