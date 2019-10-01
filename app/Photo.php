<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'photo',
        'status'
    ];

    //TODO should be photographer
//    public function user()
//    {
//        return $this->hasOne(User::class);
//    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
