<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canvas extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'width',
        'height',
        'blind_id',
    ];

    // public function control()
    // {
    //     return $this->belongsTo(Control::class);
    // }
}
