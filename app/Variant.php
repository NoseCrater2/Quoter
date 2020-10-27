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
        'type_id',
        
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

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
