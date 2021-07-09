<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexMotorizationResource extends JsonResource
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
            'code' => $this->code,
            'canvas' => $this->canvas,
            'system' => $this->system,
            'description' => $this->description,
            'width' => $this->width,
            'height' => $this->height,
            'price' => $this->price,
            'via' => $this->via,
            'motorizationType' => isset($this->motorizationType)?$this->motorizationType->name:null,
            'manufacturer' => $this->manufacturer->name,
            'type' => $this->type->name
        ];
    }
}
