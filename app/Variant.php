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
        'rotate',
        'line_id',
        'weave_id',
        'subweave_id',
        'type_id',

    ];
    public $timestamps = false;
    // protected $hidden = ['pivot'];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function subweave()
    {
        return $this->belongsTo(Subweave::class);
    }

    public function weave()
    {
        return $this->belongsTo(Weave::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->name, $this->slug);
    }

    public function scopeImage($query)
    {
        return $query->colors;
    }

}
