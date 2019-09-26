<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function Photos()
    {
        return $this->hasMany(Photo::class);
    }
}
