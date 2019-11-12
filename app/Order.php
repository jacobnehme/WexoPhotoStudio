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
    public function total(){
        $total = 0;
        foreach ($this->orderLines() as $orderLine){
            if ($orderLine->isStatus('approved')){
                $total += 100;
            }
            if ($orderLine->isStatus('pre-approved')){
                $total += 50;
            }
        }

        return $total;
    }

    public function approvedCount(){
        $count = 0;
        foreach ($this->orderLines() as $orderLine){
            if ($orderLine->isStatus('approved') or $orderLine->isStatus('pre-approved')){
                $count++;
            }
        }

        return $count;
    }
}
