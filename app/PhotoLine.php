<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoLine extends Model
{
    protected $fillable = [
        'order_id',
        'photo_id',
        'status'
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
