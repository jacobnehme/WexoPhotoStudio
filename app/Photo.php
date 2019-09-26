<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
