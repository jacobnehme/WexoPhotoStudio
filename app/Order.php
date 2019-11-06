<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'photographer_id',
    ];

    //TODO should be customer
    public function customer()
    {
        return $this->hasMany(User::class)->get()->first()->customer();
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class)->get()->first();
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    //TODO hasManyThrough Product, OrderLine
}
