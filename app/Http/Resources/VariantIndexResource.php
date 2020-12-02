<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class VariantIndexResource extends JsonResource
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
            'price' => $this->type->name === 'CORTINEROS'? $this->selectPrice(): $this->price,
            'line' => $this->line?$this->line->name:null,
            'type' => $this->type->name,
            'image' => $this->colors->random()->code,
            'width' => $this->width,
            // 'manufacturers' => $this->manufacturers->map(function($m){
            //      return $m->name;
            // }),
        ];
    }

    public function selectPrice()
    {
        $prices = new Collection();
        $prices->push( $this->ceiling_price);
        $prices->push( $this->wall_price);
        $prices->push( $this->wall_extended_price);
        $prices->push( $this->wall_double_price);
        $prices->push( $this->ceiling_wall_price);
        $prices->push( $this->curve_price);

        $new = new Collection();
        foreach ($prices as $price) {
            if($price > 0){
                $new->push($price);
            }
        }

        $selectedPrice = 0;
        if($new->min() != null){
            $selectedPrice = $new->min();
        }

        return   $selectedPrice;

    }
}
