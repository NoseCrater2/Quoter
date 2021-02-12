<?php

use Illuminate\Database\Seeder;
use App\Type;
use App\Manufacturer;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'ENROLLABLE',
            'slug' => 'enrollable',
            'max_width' => 0,
            'min_width' => 0.40,
            'max_height' => 0,
            'product_id' => 1,
            ]);

        Type::create([
            'name' => 'SHEER',
            'slug' => 'sheer',
            'max_width' => 0,
            'min_width' => 0.40,
            'max_height' => 3,
            'min_height' => 0.40,
            'profit_margin' => 0.10,
            'product_id' => 1,
        ]);

        Type::create([
            'name' => 'ROMANA',
            'slug' => 'romana',
            'max_width' => 0,
            'min_width' => 0.80,
            'max_height' => 3,
            'min_height' => 0.40,//POSIBLE CAMBIO
            'profit_margin' => 0.10,
            'product_id' => 1,
        ]); 

        Type::create([
            'name' => 'PANEL JAPONES',
            'slug' => 'panel-japones',
            'max_width' => 5.80,
            'min_width' => 0.80,
            'max_height' => 3.24,
            'min_height' => 0.50,
            'product_id' => 1,
        ]);

        Type::create([
            'name' => 'TRIPLE SHADE - SHANGRI LA',
            'slug' => 'triple-shade-sangri-la',
            'max_width' => 0,
            'min_width' => 0.60,
            'max_height' => 3.50,
            'min_height' => 1,
            'profit_margin' => 0.05,
            'product_id' => 1,   
        ]);


        Type::create([
            'name' => 'ROMANTIC',
            'slug' => 'romantic',
            'max_width' => 2.55,
            'min_width' => 0.60,
            'max_height' => 3,
            'min_height' => 0.40, //POSIBLE CAMBIO
            'product_id' => 1, 
        ]);
       
        Type::create([
            'name' => 'FLEX BALLET',
            'slug' => 'flex-ballet',
            'max_width' => 5.90,
            'min_width' => 0.50,
            'max_height' => 4,
            'min_height' => 0.40,//POSIBLE CAMBIO
            'product_id' => 1,     
        ]);

        Type::create([
            'name' => 'HORIZONTAL DE MADERA 2',
            'slug' => 'horizontal-madera-2',
            'max_width' => 2.40,
            'min_width' => 0.50,
            'max_height' => 3,
            'min_height' => 0.50,
            'product_id' => 1, 
        ]);

        Type::create([
            'name' => 'HORIZONTAL DE ALUMINIO 1',
            'slug' => 'horizontal-aluminio-1',
            'max_width' => 3,
            'min_width' => 0.40,
            'max_height' => 3,
            'min_height' => 0.25,
            'product_id' => 1, 
        ]);

        Type::create([
            'name' => 'HORIZONTAL DE ALUMINIO 2',
            'slug' => 'horizontal-aluminio-2',
            'max_width' => 3,
            'min_width' => 0.60,
            'max_height' => 3,
            'min_height' => 0.60,
            'product_id' => 1, 
        ]);

        Type::create([
            'name' => 'PERSIANAS CELULARES',
            'slug' => 'celular',
            'max_width' => 3,
            'min_width' => 0.60,
            'max_height' => 3,
            'min_height' => 1,
            'product_id' => 1,
        ]);


        Type::create([
            'name' => 'VERTICAL',
            'slug' => 'vertical',
            'max_width' => 3.50,
            'min_width' => 0.60,
            'max_height' => 3,
            'min_height' => 0.60,
            'product_id' => 1,
        ]);

        Type::create([
            'name' => 'RESIDENCIAL',
            'slug' => 'residencial',
            'product_id' => 2,
        ]);

        Type::create([
            'name' => 'ANTIBACTERIANA',
            'slug' => 'antibacteriana',
            'product_id' => 2,
        ]);
        Type::create([
            'name' => 'HAWAIANA',
            'slug' => 'hawaiana',
            'product_id' => 2,
        ]);
        Type::create([
            'name' => 'CORTINEROS',
            'slug' => 'cortineros',
            'product_id' => 2,
        ]);

        Type::create([
            'name' => 'BRAZOS INVISIBLES',
            'slug' => 'brazos-invisibles',
            'product_id' => 3,
        ]);


        Type::create([
            'name' => 'CAÍDA LIBRE',
            'slug' => 'caida-libre',
            'product_id' => 3,
        ]);
        
    }
}
