<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotorizationType extends Model
{
    protected $fillable = 
    [
        'name',
        'slug'
    ];
    public $timestamps = false;

    public function motors()
    {
        return $this->hasMany(Motor::class);
    }
}
