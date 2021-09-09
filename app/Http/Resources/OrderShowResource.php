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
                    'id' => $blind->id,
                    'canvas' => $blind->canvases->map( function ($c){
                        return [ 'width' => $c->width, 'height' => $c->height ];
                    }),
                    'celular_drive' => $blind->celular_drive,
                    'celular_type' => $blind->celular_type,
                    'celular_variant' => json_decode($blind->celular_variant),
                    'cloth_holder' => $blind->cloth_holder,
                    'color' => $blind->color,
                    'instalation_side' => $blind->instalation_side,
                    'line' => $blind->variant->weave? $blind->variant->weave->slug : null,
                    'manufacturer' => $blind->variant->line->slug,
                    'motor' => [
                        'canvas' => $blind->canvas,
                        'comment' => $blind->comment,
                        'control' => $blind->control,
                        'control_color' => $blind->control_color,
                        'drive' => $blind->drive,
                        'flexiballetPrice' => floatval($blind->flexiballet_price),
                        'frame' => $blind->frame,
                        'gallery' => $blind->gallery,
                        'galleryPrice' => floatval($blind->gallery_price),
                        'gallery_color' => isset($blind->gallery) ? $blind->gallery->color : null,
                        'height_control' => $blind->height_control,
                        'instalation_side' => $blind->instalation_side,
                        'manufacturer' => $blind->manufacturer,
                        'manufacturerPrice' => floatval($blind->manufacturer_price),
                        'motor' => isset($blind->motorization) ? $blind->motorization->id: 0,
                        'panels' => $blind->panels,
                        'price' => floatval($blind->control_price),
                        'rail_color'=> $blind->rail_color,
                        'selected_panel' => intval($blind->grouping),
                        'side_control' => $blind->control_side,
                        'stringPrice' => floatval($blind->string_price),
                        'string_type' => $blind->string_type,
                    ],
                    'motor_type' => $blind->motor_type,
                    'price' => floatval($blind->price),
                    'rotate' => $blind->rotate,
                    'second_color' => $blind->second_color,//puede no tener
                    'type' => $blind->variant->type->slug,
                    'variant' => $blind->variant_id,
                    'variant2' => $blind->second_variant_id,//puede no tener
                    'extraVertical' => floatval($blind->extraVertical),
                    'extraEnrollable' => floatval($blind->extraEnrollable)
                ];
            }),
        ];
    }
}
