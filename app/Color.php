<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color', 'code','variant_id'];
    public $timestamps = false;
    
    public function variants()
    {
        return $this->belongsTo(Variant::class);
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }

    public function awnings()
    {
        return $this->belongsToMany(Awning::class);
    }


}
