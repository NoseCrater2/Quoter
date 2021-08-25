<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'bank_account',
        'clabe',
        'name_account',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
            
}
