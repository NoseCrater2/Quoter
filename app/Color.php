<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color', 'code'];
    public $timestamps = false;

    public function variants()
    {
        return $this->belongsToMany(Variant::class);
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }

}
