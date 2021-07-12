<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'code',
        'description',
        'price',
        'channel',
        'manufacturer'
    ];
}
