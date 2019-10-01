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

    public function approve($status = true)
    {
        $this->update(['status' => $status]);
    }

    public function reject()
    {
        $this->approve(false);
    }
}
