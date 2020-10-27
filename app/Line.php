<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['name', 'matrix_id'];
    public $timestamps = false;

 

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function Matrix()
    {
        return $this->belongsTo(Matrix::class);
    }

}
