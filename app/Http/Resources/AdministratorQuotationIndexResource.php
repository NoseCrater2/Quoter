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
            'order' => 'PT'.Carbon::parse($this->created_at)->format('dmy').'/'.$this->id,
            'blinds' => $this->blinds->count(),
            'user' => $this->user->name.' '.$this->user->last_name,
            'total' => $this->blinds->map( function( $blind ){
                return $blind->price +
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
