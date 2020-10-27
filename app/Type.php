<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $fillable = ['name']; 
    public $timestamps = false;

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
