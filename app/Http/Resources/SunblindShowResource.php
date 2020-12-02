<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SunblindShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'colors' => $this->colors->map(function( $color ){
                return ['color' => $color->color, 'code' => $color->code];
            }),
           
        ];
    }
}
