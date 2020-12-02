<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class TypeIndexResurce extends JsonResource
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
            'product' => $this->product->name,
            'name' => $this->name,
            'slug' => $this->slug,
            'lines' => $this->lines->count(),
            'max_width' => $this->max_width,
            'min_width' => $this->min_width,
            'max_height' => $this->max_height,
            'min_height' => $this->min_height,
            'max_width_rot' => $this->max_width_rot,
            'min_width_rot' => $this->min_width_rot,
            'max_height_rot' => $this->max_height_rot,
            'min_height_rot' => $this->min_height_rot,
            'profit_margin' => $this->profit_margin,
        ];
    }
}
