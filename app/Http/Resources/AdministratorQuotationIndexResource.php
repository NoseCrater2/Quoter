<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AdministratorQuotationIndexResource extends JsonResource
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
            'state' => Carbon::now()->diffInDays($this->created_at) > 20 ?'No':'Sí',
            'order' => $this->user->id.'PT'.Carbon::parse($this->created_at)->format('dmy').$this->id,
            'blinds' => $this->blinds->count(),
            'user' => $this->user->name.' '.$this->user->last_name,
            'total' => $this->blinds->map( function( $blind ){
                $countSameBlinds = ($blind->count_same_blinds <= 0) ? 1 : $blind->count_same_blinds;
                return ($blind->discount_price == 0 ? $blind->price : $blind->discount_price +
                        ( isset($blind->motorization) ? $blind->motorization->price: 0) +
                        ( isset($blind->control) ? $blind->control->price: 0) +
                        (isset($blind->gallery) ? $blind->gallery->price : 0) +
                        $blind->installmentCharge +
                        $blind->flexiballet_price +
                        $blind->gallery_price +
                        $blind->manufacturer_price +
                        $blind->string_price  +
                        $blind->extraVertical +
                        $blind->extraEnrollable) * $countSameBlinds;
            })->sum(),
            'created_at' => Carbon::parse($this->created_at)->toFormattedDateString(),
            'updated_at' =>Carbon::parse($this->updated_at)->toFormattedDateString(),

        ];
    }
}
