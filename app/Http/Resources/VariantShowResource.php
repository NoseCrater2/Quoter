<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

use function PHPSTORM_META\type;

class VariantShowResource extends JsonResource
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
            'product' => $this->type->product->name,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'line' => $this->line?$this->line->name:null,
            'slugLine' => $this->line?$this->line->slug:null,
            'type' => $this->type->slug,
            'width' => $this->width,
            'description' => $this->description,
            'manufacturer' => $this->manufacturers[0]->name,
            'max_width' => $this->type->max_width,
            'min_width' => $this->type->min_width,
            'max_height' => $this->type->max_height,
            'min_height' => $this->type->min_height,
            'max_width_rot' => $this->type->max_width_rot,
            'min_width_rot' => $this->type->min_width_rot,
            'max_height_rot' => $this->type->max_height_rot,
            'min_height_rot' => $this->type->min_height_rot,
            'profit_margin' => $this->type->profit_margin,
            'weights' => $this->weights->map(function( $weight ){
                return ['code' => $weight->code, 'weight' => $weight->weight, 'width' => $weight->width];
            }),
            'colors' => $this->colors->map(function( $color ){
                return ['color' => $color->color, 'code' => $color->code, 'rotate' => $color->rotate];
            }),
        ];
    }

  
}
