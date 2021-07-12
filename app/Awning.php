<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Awning extends Model
{
    protected $fillable = ['name', 'slug','price','subweave_id'];
    
    public $timestamps = false;

    public function colors()
    {
        return $this->belongsToMany(Weave::class);
    }

    public function subweave()
    {
        return $this->belongsTo(Subweave::class);
    }
}
