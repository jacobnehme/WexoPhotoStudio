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

    public function orderLine()
    {
        return $this->belongsTo(OrderLine::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
