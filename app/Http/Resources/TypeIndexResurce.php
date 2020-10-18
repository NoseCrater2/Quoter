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
            'name' => $this->name,
            'lines' => $this->lines->map(function ( $line)
            {
                return $line->id;
            })
        ];
    }
}