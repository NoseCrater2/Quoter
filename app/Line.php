<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;
    protected $hidden = ['pivot'];

 

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }


    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function subweaves()
    {
        return $this->hasMany(Subweave::class);
    }

    

}
