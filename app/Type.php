<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $fillable = ['name', 'manufacturer_id']; 
    public $timestamps = false;

    public function lines()
    {
        return $this->belongsToMany(Line::class);
    }
}
