<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'model',
        'price',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }
}
