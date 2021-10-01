<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotatioIndexResource extends JsonResource
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
            'state' => Carbon::now()->diffInDays($this->updated_at, true) < 20,
            'order' => $this->user->id.'PT'.Carbon::parse($this->created_at)->format('dmy').$this->id,
            'blinds' => $this->blinds->count(),
            'total' => $this->blinds->map( function( $blind ){
                return $blind->discount_price == 0 ? $blind->price : $blind->discount_price +
                        ( isset($blind->motorization) ? $blind->motorization->price: 0) +
                        ( isset($blind->control) ? $blind->control->price: 0) +
                        $blind->flexiballet_price +
                        $blind->gallery_price +
                        $blind->manufacturer_price +
                        $blind->string_price;
            })->sum(),
            'created_at' => Carbon::parse($this->created_at)->toFormattedDateString(),
            'updated_at' =>Carbon::parse($this->updated_at)->toFormattedDateString(),
            'validity' =>Carbon::parse($this->updated_at)->addDays(20)->format('d/m/Y'),

        ];
    }
}
