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
        'confirmed',
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

    //Objects
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

    //Methods
    public function total()
    {
        $total = 0;

//        foreach ($this->orderLines() as $orderLine) {
//            switch ($orderLine->status_id) {
//                case Status::approved():
//                    $total += 100;
//                    break;
//                case Status::preApproved():
//                    $total += 50;
//                    break;
//            }
//        }

        $count = $this->orderLines()->count();
        //$approved = $this->orderLines()->where('status_id', Status::approved())->count();
        $preApproved = $this->orderLines()->where('status_id', Status::preApproved())->count();

        //$total = ($approved * 100) + ($preApproved * 50);
        $total = ($count * 100) - ($preApproved * 50);

        return $total;
    }

    public function approvedCount()
    {
//        $count = 0;
//        foreach ($this->orderLines() as $orderLine) {
//            if ($orderLine->isStatus('approved') or $orderLine->isStatus('pre-approved')) {
//                $count++;
//            }
//        }

        $approved = $this->orderLines()->where('status_id', Status::approved())->count();
        $preApproved = $this->orderLines()->where('status_id', Status::preApproved())->count();

        $count = $approved + $preApproved;

        return $count;
    }
}
