<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weave extends Model
{
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;
    protected $hidden = ['pivot'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function subweaves()
    {
        return $this->belongsToMany(Subweave::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
}
