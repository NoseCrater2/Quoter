<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['name', 'slug','type_name'];
    public $timestamps = false;

 

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function weaves()
    {
        return $this->belongsToMany(Weave::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

}
