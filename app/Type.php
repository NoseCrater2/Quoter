<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $fillable = [
        'name',
        'image',
        'slug',
        'max_width',
        'min_width',
        'max_height',
        'min_height',
        'max_width_rot',
        'min_width_rot',
        'max_height_rot',
        'min_height_rot',
        'profit_margin',
        'product_id',
    ]; 
    public $timestamps = false;

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Line::class);
    }

   
}
