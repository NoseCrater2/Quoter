<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantIndexResource extends JsonResource
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
            'price' => $this->price,
             'line' => $this->line->name,
            // 'type' => $this->type->name,
            // 'colors' => $this->colors->map(function($color){
            //     return $color->color;
            // }),

            // 'manufacturers' => $this->manufacturers->map(function($m){
            //     return $m->name;
            // }),
        ];
    }
}
