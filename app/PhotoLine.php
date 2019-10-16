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

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function orderLine()
    {
        return $this->belongsTo(OrderLine::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function isPending(){
        return $this->status->id == Status::pending();
    }

    public function isApproved(){
        return $this->status->id == Status::approved();
    }

    public function approve()
    {
        $this->update(['status_id' => Status::approved()]);
    }

    public function reject()
    {
        $this->update(['status_id' => Status::rejected()]);
    }
}
