<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserIndexResource extends JsonResource
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
            'email' => $this->email,
            'fiscal_address' => $this->fiscal_address,
            'shipping_address' => $this->shipping_address,
            'phone_number' => $this->phone_number,
            'movil_number' => $this->movil_number,
            'logo' => $this->logo,
            'discount_percent' => $this->discount_percent,
            'roles' => isset($this->getRoleNames()[0])? $this->getRoleNames()[0]: null,
           
        ];
    }
}
