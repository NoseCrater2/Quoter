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
        'width',
        'height',
        'price',
        'via',
        'motorization_type_id',
        'line_id',
        'type_id',
        'active'
     ];

     public function motorizationType()
     {
        return $this->belongsTo(MotorizationType::class);
     }

     public function line()
     {
      return $this->belongsTo(Line::class);
     }
     public function type()
     {
      return $this->belongsTo(Type::class);
     }

     protected $casts = [
        'motorization_type_id' => 'integer',
        'line_id' => 'integer',
        'type_id' => 'integer'
    ];

}
