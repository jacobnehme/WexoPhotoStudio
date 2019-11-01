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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class)->get()->first();
    }
}
