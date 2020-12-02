<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sunblind extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'weave_id',
    ];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function weave()
    {
        return $this->belongsTo(Weave::class);
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
