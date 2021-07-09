<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug'];

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    public function variants()
    {
        return $this->hasManyThrough(Variant::class, Type::class);
    }
}
