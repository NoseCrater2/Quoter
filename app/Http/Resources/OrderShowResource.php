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
        //ORDER
        $code = $this->ticket?'PT':'P';
        //'order' => $code.Carbon::parse($this->created_at)->format('dmy').'/'.$this->id,
        //'state' => $this->state,


        //QUOTATION
        // 'state' => Carbon::now()->diffInDays($this->updated_at, true) < 20,
        // 'order' => 'PT'.Carbon::parse($this->created_at)->format('dmy').'/'.$this->id,
        //
        return [

            'id' => $this->id,
            'payed' => $this->ticket,
            'state' => $this->is_quotation? Carbon::now()->diffInDays($this->updated_at, true) < 20 : $this->state,
            'order' => $this->is_quotation? $this->user->id.'PT'.Carbon::parse($this->created_at)->format('dmy').$this->id : $this->user->id.$code.Carbon::parse($this->created_at)->format('dmy').$this->id,
            'user' => $this->user,
            'is_quotation' => intval($this->is_quotation),
            'validity' =>Carbon::parse($this->updated_at)->addDays(20)->format('d/m/Y'),
            'created_at' => Carbon::parse($this->created_at)->toFormattedDateString(),
            'total' => $this->blinds->map( function( $blind ){
                $countSameBlinds = ($blind->count_same_blinds <= 0) ? 1 : $blind->count_same_blinds;
                return ($blind->discount_price +
                        ( isset($blind->motorization) ? $blind->motorization->price: 0) +
                        ( isset($blind->control) ? $blind->control->price: 0) +
                        (isset($blind->gallery) ? $blind->gallery->price : 0) +
                        $blind->installmentCharge +
                        $blind->flexiballet_price +
                        $blind->gallery_price +
                        $blind->manufacturer_price +
                        $blind->string_price +
                        $blind->extraVertical +
                        $blind->extraEnrollable) * $countSameBlinds;
            })->sum(),
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
                    'line' => $blind->line,
                    'manufacturer' => $blind->manufacturer,
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
                        'instalation_side' => $blind->motor_instalation_side,
                        'manufacturer' => isset($blind->motorization) ? $blind->motorization->manufacturer : null,
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
                    'base_price' => floatval($blind->base_price),
                    'count_same_blinds' =>intval($blind->count_same_blinds),
                    'discount_price' => floatval($blind->discount_price),
                    'installmentCharge' => floatval($blind->installmentCharge),
                    'rotate' => $blind->rotate,
                    'second_color' => $blind->second_color,//puede no tener
                    'type' => $blind->type,
                    'variant' => $blind->variant,
                    'variant2' => $blind->second_variant,//puede no tener
                    'extraVertical' => floatval($blind->extraVertical),
                    'extraEnrollable' => floatval($blind->extraEnrollable)
                ];
            }),
        ];
    }
}
