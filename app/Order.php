<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'state',
        'subtotal',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blinds()
    {
        return $this->hasMany(Blind::class);
    }
}
