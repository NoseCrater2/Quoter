<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorIndexResource extends JsonResource
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
            'color' => $this->color,
            'code' => $this->code,
            'rotate' => $this->rotate,
        ];
    }
}
