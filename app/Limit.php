<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $fillable = 
    [
        'width',
        'height',
        'limit_height',
    ];

    public function variants()
    {
        return $this->belongsToMany(Variant::class);
    }
}
