<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

use function PHPSTORM_META\type;

class VariantShowResource extends JsonResource
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
            'type_product_id' => $this->type->product->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->type->name === 'CORTINEROS'? $this->selectPrice(): $this->price,
            'line' => $this->line?$this->line->name:null,
            'slugLine' => $this->line?$this->line->slug:null,
            'type' => $this->type->name,
            'width' => $this->width,
            'description' => $this->description,
            'finished' => $this->finished,//EMPIEZA CARACTERISTICAS DE CORTINAS
            'strip_width' => $this->strip_width,
            'ceiling_price' => $this->ceiling_price,
            'wall_price' => $this->wall_price,
            'wall_extended_price' => $this->wall_extended_price,
            'wall_double_price' => $this->wall_double_price,
            'ceiling_wall_price' => $this->ceiling_wall_price,
            'curve_price' => $this->curve_price,//TERMINA CARACTERISTICAS DE CORTINAS
            'max_width' => $this->type->max_width,
            'min_width' => $this->type->min_width,
            'max_height' => $this->type->max_height,
            'min_height' => $this->type->min_height,
            'max_width_rot' => $this->type->max_width_rot,
            'min_width_rot' => $this->type->min_width_rot,
            'max_height_rot' => $this->type->max_height_rot,
            'min_height_rot' => $this->type->min_height_rot,
            'profit_margin' => $this->type->profit_margin,
            'weights' => $this->weights->map(function( $weight ){
                return ['code' => $weight->code, 'weight' => $weight->weight, 'width' => $weight->width];
            }),
            'colors' => $this->colors->map(function( $color ){
                return ['color' => $color->color, 'code' => $color->code, 'rotate' => $color->rotate];
            }),
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
