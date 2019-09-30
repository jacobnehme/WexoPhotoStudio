<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //TODO should be customer
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    //TODO hasManyThrough Product, OrderLine
}
