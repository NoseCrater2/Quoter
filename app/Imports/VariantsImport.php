<?php

namespace App\Imports;

use App\Variant;
use App\Type;
use App\Line;
use App\Color;
use App\Manufacturer;
use App\Weight;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class VariantsImport implements WithHeadingRow, ToCollection, SkipsOnError, WithValidation, SkipsOnFailure
{
    
   use Importable, SkipsErrors, SkipsFailures;


public function collection(Collection $rows)
{
   
    foreach ($rows as $row) {
        
        $line = null;
        $type = Type::firstOrCreate([
            'name' => $row['tipo'],
        ]);


       if($row->has('linea') && $row['linea']){
            $line =  Line::firstOrCreate([
                'name' =>  $row['linea'],
            ],[
                'slug' => str_replace(" ", '-', strtolower($row['linea'])),
            ]);

            $type->lines()->syncWithoutDetaching([$line->id]);
       }
       
       

        $color = Color::firstOrCreate([
           
            'code' => $row['codigo'],
        ],
            [
                'color' => $row['color'],
                'rotate' =>$row->has('rotacion')?$row['rotacion']:0
            ]
        );

        $variant = Variant::firstOrCreate(
            ['name' => $row['modelo']],
            [
                'slug' => str_replace(" ", '-',$row['modelo']),
                'width' => $row->has('ancho')?$row['ancho']:1,
                'finished' => $row->has('acabado') ? $row['acabado'] : null,
                'strip_width' => $row->has('tira') ? $row['tira'] : 0,
                'ceiling_price' => $row->has('precio_techo') ? $row['precio_techo'] : 0,
                'wall_price' => $row->has('precio_pared') ? $row['precio_pared'] : 0,
                'wall_extended_price' => $row->has('precio_pared_extendido') ? $row['precio_pared_extendido'] : 0,
                'wall_double_price' => $row->has('precio_pared_doble') ? $row['precio_pared_doble'] : 0,
                'ceiling_wall_price' => $row->has('precio_techo_pared') ? $row['precio_techo_pared'] : 0,
                'curve_price' => $row->has('precio_doble') ? $row['precio_doble'] : 0,
                'price' => $row->has('precio')?$row['precio']:0,
                'description' => $row->has('descripcion')?$row['descripcion']:null,
                'line_id' => $line != null ? $line->id : null,
                'type_id' => $type->id,
            ]      
        );

        if($row->has('codigo_cortinero')){
           Weight::firstOrCreate(
                ['code' => $row['codigo_cortinero']],
                [
                    'weight' => $row['peso'],
                    'width' => $row['ancho_cortinero'],
                    'variant_id' => $variant->id,
                ],
            );
        }

        if($row->has('fabricante') && $row['fabricante']){
            $manufacturer = Manufacturer::firstOrCreate([
                'name' => $row['fabricante']
            ]);
            
            $variant->manufacturers()->syncWithoutDetaching([$manufacturer->id]);
        }

        // $variant->line_id = $line->id


        $variant->colors()->syncWithoutDetaching([$color->id]);

       
    }
}
 



   public function rules(): array
   {
       return [
           '*.tipo' => ['required', 'string'],
           '*.linea' => ['nullable', 'string'],
           '*.fabricante' => ['nullable','string'],
           '*.codigo' => ['nullable','string'],
           '*.codigo_cortinero' => ['numeric'],
           '*.ancho_cortinero' => ['nullable','numeric', 'min:0'],
           '*.color' => ['nullable'],
           '*.rotacion' => ['nullable','in:0,1'],
           '*.modelo' => ['required','string'],
           '*.ancho' => ['nullable','numeric', 'min:0'],
           '*.terminado' => ['nullable','string'],
           '*.tira' => ['nullable','numeric', 'min:0'],
           '*.precio' => ['nullable','numeric','min:0'],
           '*.peso' => ['nullable','numeric','min:0'],
           '*.ancho_cortinero' => ['nullable','numeric','min:0'],
           '*.descripcion' => ['nullable','string'],
           '*.acabado' => ['nullable','string'],
           '*.peso' => ['nullable','numeric','min:0'],
           '*.precio_techo' => ['nullable','numeric','min:0'],
           '*.precio_pared' => ['nullable','numeric','min:0'],
           '*.precio_pared_extendido' => ['nullable','numeric','min:0'],
           '*.precio_pared_doble' => ['nullable','numeric','min:0'],
           '*.precio_techo_pared' => ['nullable','numeric','min:0'],
           '*.precio_doble' => ['nullable','numeric','min:0'],
       ];
   }

//    'description',
//   'finished',
//    'weight',
//    'ceiling_price',
//    'wall_price',
//    'wall_extended_price',
//    'wall_double_price',
//    'ceiling_wall_price',
//    'curve_price',

  
}
