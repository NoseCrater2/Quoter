<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    public $timestamps = false;
    protected $fillable =
    [
        'title',
        'path',
        'thumbnail',
        'is_promo'
    ];


}
