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

        'payment_channel', //string; Netpay, Spei, Oxxo, Banco (para tarjetas crédito y débito sin Netpay)
        'card_type', //string; crédito y débito
        'months_interest_free', //string; numero de meses
        'order_date_at' //string; fecha de compra
    ];

    protected $casts = [
        'order_date_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
