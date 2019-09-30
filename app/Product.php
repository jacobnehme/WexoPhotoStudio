<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function OrderLine()
    {
        return $this->belongsTo(OrderLine::class);
    }

    public function Photos()
    {
        return $this->hasMany(Photo::class);
    }
}
