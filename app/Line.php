<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }
}
