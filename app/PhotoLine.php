<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoLine extends Model
{
    protected $fillable = [
        'order_line_id',
        'photo_id',
        'status_id',
    ];

    //Relations
    public function _photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function _orderLine()
    {
        return $this->belongsTo(OrderLine::class);
    }

    //Objects
    public function photo()
    {
        return $this->belongsTo(Photo::class)->get()->first();
    }

    public function orderLine()
    {
        return $this->belongsTo(OrderLine::class)->get()->first();
    }
}
