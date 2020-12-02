<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color', 'code', 'rotate'];
    public $timestamps = false;

    public function variants()
    {
        return $this->belongsToMany(Variant::class);
    }

    public function sunblinds()
    {
        return $this->belongsToMany(Sunblind::class);
    }
}
