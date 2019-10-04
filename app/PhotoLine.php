<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoLine extends Model
{
    protected $fillable = [
        'order_line_id',
        'photo_id',
        'is_approved',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function orderLine()
    {
        return $this->belongsTo(OrderLine::class);
    }

    //TODO more sophisticated status control needed
    public function approve($status = true)
    {
        $this->update(['is_approved' => $status]);
    }

    public function reject()
    {
        $this->approve(false);
    }
}
