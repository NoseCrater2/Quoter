<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $code = $this->ticket?'PT':'P';
        return [
            'id' => $this->id,
            'order' => $code.Carbon::parse($this->created_at)->format('dmy').'/'.$this->id,
            'blinds' => $this->blinds->count(),
            'state' => $this->state,
            'total' => $this->blinds->map( function( $blind ){
                return $blind->discount_price +
                        ( isset($blind->motorization) ? $blind->motorization->price: 0) +
                        ( isset($blind->control) ? $blind->control->price: 0) +
                        $blind->flexiballet_price +
                        $blind->gallery_price +
                        $blind->manufacturer_price +
                        $blind->string_price;
            })->sum(),
            'created_at' => Carbon::parse($this->created_at)->toFormattedDateString(),
            'updated_at' =>Carbon::parse($this->updated_at)->toFormattedDateString(),
            
        ];
    }
}
