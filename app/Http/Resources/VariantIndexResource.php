<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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

        $color =  $this->colors->first(function ($color) {
            return Storage::exists('modelos/medium/'.$color->code.'.jpg');
        });
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'weave' => isset($this->weave)?$this->weave->slug:null,
            'price' => $this->price,
            'line' => $this->line?$this->line->slug:null,
            'type' => $this->type->slug,
            'image' =>  $color != null ? $color->code: 'modelos/medium-unavailable',
            'product' => $this->type->product->slug,
            'rotate' => $this->rotate,
            'width' => $this->width,
            'manufacturer' => $this->manufacturers->isNotEmpty()?$this->manufacturers[0]->name:null,
            'manufacturer_id' => $this->manufacturers->isNotEmpty()?$this->manufacturers[0]->id:null
        ];
    }
}
