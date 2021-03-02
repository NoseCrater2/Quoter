<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blind extends Model
{
    protected $fillable = [
        'order_id',
        'variant_id',
        'color_id',
        'cloth_holder',//default: false
        'control_side',//opcional 
        'panels',//opcional default: 0
        'control_color',//opcional
        'grouping',//opcional
        'manufacturer',//opcional
        'string_type',//opcional
        'gallery_id',//opcional
        'motorization_id',//opcional
        'control_id'//opcional
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function motorization()
    {
        return $this->belongsTo(Motorization::class);
    }

    public function control()
    {
        return $this->belongsTo(Control::class);
    }

    public function canvas()
    {
        return $this->hasMany(Canvas::class);
    }
}
