<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderShowResource extends JsonResource
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
            // 'state' => $this->state,
            'blinds' => $this->blinds->map(function($blind)
            {
                return [
                    'type' => $blind->variant->type->name,
                    'line' => $blind->variant->line->name,
                    'vatiant' => $blind->variant->name,
                    'price' => $blind->variant->price,
                    'color' => $blind->color->color,
                    'code' => $blind->color->code,
                    'cloth_holder' => $blind->cloth_holder,
                    'control_sie' => $blind->control_side,
                    'panels' => $blind->panels,
                    'control_color' => $blind->control_color,
                    'grouping' => $blind->grouping,
                    'manufacturer' => $blind->manufacturer,
                    'string_type' => $blind->string_type,
                    'gallery' => isset($blind->gallery)?$blind->gallery->model:null,
                    'gallery_price' => isset($blind->gallery)?$blind->gallery->price:0,
                    'motorization_code' => isset($blind->motorization)?$blind->motorization->code:null,
                    'motorization_system' => isset($blind->motorization)?$blind->motorization->system:null,
                    'motorization_description' => isset($blind->motorization)?$blind->motorization->description:null,
                    'motorization_price' => isset($blind->motorization)?$blind->motorization->price:null,
                    'control' => isset($blind->control)?$blind->control:null

                ];
            }),
            // 'total' => $this->total,
            // 'subtotal' => $this->subtotal,
            // 'created_at' => Carbon::parse($this->created_at)->toFormattedDateString(),
            // 'updated_at' =>Carbon::parse($this->updated_at)->toFormattedDateString(),
        ];
    }
}
