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
            'last_name' => $this->last_name,
            'email' => $this->email,
            'rfc' => $this->rfc,
            'company' => $this->company,
            'address' => $this->address,
            'ship_address' => $this->ship_address,
            'second_ship_address' => $this->second_ship_address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'discount_percent' => $this->discount_percent,
            'role' => $this->roles->isNotEmpty()? $this->getRoleNames()[0]: null,
            'active' => intval($this->active)

        ];
    }
}
