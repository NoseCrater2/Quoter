<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SunblindIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $index = rand(1,$this->colors->count());
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'isSunblind' => true,
            'image' => $this->colors[$index-1]->code,
           
        ];
    }
}
