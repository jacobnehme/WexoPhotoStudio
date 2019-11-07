<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'photographer_id',
        'product_id',
        'path',
    ];

    //Relations
    public function _product()
    {
        return $this->belongsTo(Product::class);
    }

    public function _photographer()
    {
        return $this->belongsTo(Photographer::class);
    }

    //Objects
    public function product()
    {
        return $this->belongsTo(Product::class)->get()->first();
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class)->get()->first();
    }
}
