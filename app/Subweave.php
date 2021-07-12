<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subweave extends Model
{
    protected $fillable = ['name', 'slug','line_id','type_id'];
    public $timestamps = false;
    protected $hidden = ['pivot'];
    
    public function weaves()
    {
        return $this->belongsToMany(Weave::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }


}
