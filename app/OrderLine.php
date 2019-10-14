<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function photoLines()
    {
        return $this->hasMany(PhotoLine::class);
    }

    public function approveAll(){
        foreach ($this->photoLines as $photoLine){
            $photoLine->approve();
        }
    }

    public function rejectAll(){
        foreach ($this->photoLines as $photoLine){
            $photoLine->reject();
        }
    }

    public function approvedCount(){
        return $this->photoLines->where('is_approved', '==', true)->count();
    }
}
