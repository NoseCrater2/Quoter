<?php

namespace App;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;

class Sunblind extends Model  implements Searchable
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'weave_id',
    ];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function weave()
    {
        return $this->belongsTo(Weave::class);
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
