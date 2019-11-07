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

    //Relations
    public function _orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function _photographer()
    {
        return $this->belongsTo(Photographer::class);
    }

    public function _customer()
    {
        return $this->hasMany(Customer::class);
    }

    //Object
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class)->get();
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class)->get()->first();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->get()->first();
    }
}
