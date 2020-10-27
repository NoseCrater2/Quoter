<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color', 'full_image', 'tumb_image'];
    public $timestamps = false;

    public function variants()
    {
        return $this->belongsToMany(Variant::class);
    }
}
