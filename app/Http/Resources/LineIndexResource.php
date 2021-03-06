<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LineIndexResource extends JsonResource
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
            'types' => $this->types->map( function($type){
                return $type->slug;
            }),
            // 'details' => $this->weaves->map( function($weave){
            //     return ["slug" => $weave->slug, "name" => $weave->name];
            // }),
            // 'weaves' => $this->weaves->count(),
        ];
    }
}
