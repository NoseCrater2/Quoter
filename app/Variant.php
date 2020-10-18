<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = 
    [
        'name',
        'price',
        'line_id',
        
    ];
    public $timestamps = false;

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

  

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function limits()
    {
        return $this->belongsToMany(Limit::class);
    }
}
