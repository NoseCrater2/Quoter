<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
