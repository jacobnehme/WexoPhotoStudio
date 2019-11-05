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
        return $this->belongsTo(User::class)->get()->first()->photographer();
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function calcOrderLinePrice()
    {
        // TODO Refactor Or WHERE statement
        $preApprovedPrice  = 50;
        $defaultPrice      = 100;
        $orderLines        = $this->orderLines()->get();
        $pendingTotalPrice = $defaultPrice * $orderLines->where('status_id', '==', 1)->count();
        $rejectTotalPrice  = $defaultPrice * $orderLines->where('status_id', '==', 2)->count();
        $preTotalPrice     = $preApprovedPrice * $orderLines->where('status_id', '==', 3)->count();

        return $pendingTotalPrice + $rejectTotalPrice + $preTotalPrice;


    }
    //TODO hasManyThrough Product, OrderLine
}
