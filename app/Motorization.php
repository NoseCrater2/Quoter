<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorization extends Model
{
    public $timestamps = false;
     protected $fillable = [
        'code',
        'canvas',
        'system',
        'description',
        'width',
        'height',
        'price',
        'via',
        'motorization_type_id',
        'manufacturer_id',
        'type_id',
     ];

     public function motorizationType()
     {
        return $this->belongsTo(MotorizationType::class);
     }

     public function manufacturer()
     {
        return $this->belongsTo(Manufacturer::class);
     }

     public function type()
     {
      return $this->belongsTo(Type::class);
     }

}
