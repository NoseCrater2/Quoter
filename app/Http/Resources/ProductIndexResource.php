<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
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
            'description' => $this->description,
            'types' => $this->types->map(function($type){
                return [
                    'name' => $type->id == 9 || $type->id == 10 ?$type->name."''":$type->name,
                    'slug' => $type->slug,
                    'id' => $type->id,
                    'lines' => $type->lines->count(),
                    'max_width' => $type->max_width,
                    'min_width' => $type->min_width,
                    'max_height' => $type->max_height,
                    'min_height' => $type->min_height,
                    'max_width_rot' => $type->max_width_rot,
                    'min_width_rot' => $type->min_width_rot,
                    'max_height_rot' => $type->max_height_rot,
                    'min_height_rot' => $type->min_height_rot,
                    'profit_margin' => $type->profit_margin,
                ];
            }),
        ];

        
    }
}
