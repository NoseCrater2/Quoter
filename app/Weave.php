<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weave extends Model
{
    protected $fillable = ['name', 'slug', 'description'];
    public $timestamps = false;

    public function sunblinds()
    {
        return $this->hasMany(Sunblind::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Line::class);
    }
}
