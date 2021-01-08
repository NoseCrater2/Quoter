<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weave extends Model
{
    protected $fillable = ['name', 'slug', 'description'];
    public $timestamps = false;

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Line::class);
    }
}
