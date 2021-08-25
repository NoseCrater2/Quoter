<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'state',
        'is_quotation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blinds()
    {
        return $this->hasMany(Blind::class);
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
