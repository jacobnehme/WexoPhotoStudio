<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'status'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
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
