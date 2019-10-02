<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //TODO should be photographer
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
