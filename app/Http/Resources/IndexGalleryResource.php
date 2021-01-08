<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexGalleryResource extends JsonResource
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
            'model' => $this->model,
            'price' => $this->price,
            'type' => $this->type->name,
            'colors' => $this->colors->map(function($color){
                return ['color' => $color->color];
            })
        ];
    }
}
