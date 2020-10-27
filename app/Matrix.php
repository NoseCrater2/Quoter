<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    public $timestamps = false;

    public function lines()
    {
        return $this->hasMany(Lines::class);
    }
}
