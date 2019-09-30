<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    public function OrderLine()
    {
        return $this->belongsTo(OrderLine::class);
    }

    public function Photos()
    {
        return $this->hasMany(Photo::class);
    }
}
