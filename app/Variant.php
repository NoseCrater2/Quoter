<?php

namespace App;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model implements Searchable
{
    protected $fillable = 
    [
        'name',
        'slug',
        'price',
        'width',
        'description',
        'finished',//CORTINERO
        'strip_width',//PERSIANA
        'ceiling_price',//CORTINERO
        'wall_price',//CORTINERO
        'wall_extended_price',//CORTINERO
        'wall_double_price',//CORTINERO
        'ceiling_wall_price',//CORTINERO
        'curve_price',//CORTINERO
        'rotate',
        'line_id',
        'weave_id',
        'type_id',
        
    ];
    public $timestamps = false;

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function weave()
    {
        return $this->belongsTo(Weave::class);
    }

    public function weights()
    {
        return $this->hasMany(Weight::class);
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

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->name, $this->slug);
    }


}
