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
        'status_id',
    ];

    //Relations
    public function _order()
    {
        return $this->belongsTo(Order::class);
    }

    public function _product()
    {
        return $this->belongsTo(Product::class);
    }

    public function _status(){
        return $this->belongsTo(Status::class);
    }

    public function _photoLines(){
        return $this->hasMany(PhotoLine::class);
    }

    //Objects
    public function order()
    {
        return $this->belongsTo(Order::class)->get()->first();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->get()->first();
    }

    public function status(){
        return $this->belongsTo(Status::class)->get()->first();
    }

    public function photoLines(){
        return $this->hasMany(PhotoLine::class)->get();
    }

    //Methods
    public function isStatus($status){
        return $this->status_id == Status::statusId($status);
    }

    public function setStatus($status){
        $this->update(['status_id' => Status::statusId($status)]);
    }

    public function pending()
    {
        $this->update(['status_id' => Status::pending()]);
    }

    public function active()
    {
        $this->update(['status_id' => Status::active()]);
    }

    public function reject()
    {
        $this->update(['status_id' => Status::rejected()]);
    }

    public function approve()
    {
        $this->update(['status_id' => Status::approved()]);
    }

    public function preApprove()
    {
        $this->update(['status_id' => Status::preApproved()]);
    }
}
