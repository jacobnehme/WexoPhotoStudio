<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoLine extends Model
{
    protected $fillable = [
        'order_line_id',
        'photo_id',
        'status'
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
        $this->update(['status' => $status]);
    }

    public function reject()
    {
        $this->approve(false);
    }

//    TODO make these functions inside orderline perhaps
    public function getApproved_Count()
    {
        return $this->where('status', '!=', false)->count();
    }

    public function getRejected_Count()
    {
        return $this->where('status', '==', false)->count();
    }

}
