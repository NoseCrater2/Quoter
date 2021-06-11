<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blind extends Model
{
    protected $fillable = [
        'order_id',
        'variant_id',
        'color_id',

        'second_variant_id',//nueva (null)
        'second_color_id',//nueva (null)
        'celular_drive',//nueva (null)
        'celular_type',//nueva (null)
        'celular_variant',//nueva (null)
        'instalation_side',//nueva (null)
        'motor_type',//nueva (null)
        'price',//nueva (0.0)
        'rotate',//nueva (false)
        'canvas',//nueva (0)
        'comment',//nueva (null)
        'drive',// nueva null
        'flexiballet_price', //nueva (0)
        'frame', //nueva null
        'gallery_price', //nueva 0
        'height_control', //null
        'instalation_side', // null
        'manufacturer_price',// 0
        'control_price', // 0
        'rail_color', // null
        'string_price', // 0

        'cloth_holder',
        'control_side', 
        'panels',
        'control_color',
        'grouping',
        'manufacturer',
        'string_type',
        'gallery_id',
        'motorization_id',
        'control_id'
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

    public function second_color()
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

    public function canvases()
    {
        return $this->hasMany(Canvas::class);
    }
}
