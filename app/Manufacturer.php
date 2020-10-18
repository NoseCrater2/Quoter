<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    //
    protected $fillable = ['name', 'short_name']; 
    public $timestamps = false;

    public function lines()
    {
        return $this->belongsToMany(Line::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
