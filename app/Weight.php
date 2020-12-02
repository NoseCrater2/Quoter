<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'code',
        'weight',
        'width',
        'variant_id',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
