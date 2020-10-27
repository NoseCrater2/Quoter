<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    //
    protected $fillable = ['name', 'short_name']; 
    public $timestamps = false;

    public function variants()
    {
        return $this->belongsToMany(Variant::class);
    }

}
