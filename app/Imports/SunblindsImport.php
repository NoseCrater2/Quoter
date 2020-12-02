<?php

namespace App\Imports;

use App\Sunblind;
use App\Type;
use App\Line;
use App\Color;
use App\Manufacturer;
use App\Weave;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SunblindsImport implements WithHeadingRow, ToCollection, SkipsOnError, WithValidation, SkipsOnFailure
{
    
   use Importable, SkipsErrors, SkipsFailures;


public function collection(Collection $rows)
{
    foreach ($rows as $row) {

        $type = Type::firstOrCreate([
            'name' => $row['tipo'],
        ]);


    
            $line =  Line::firstOrCreate([
                'name' =>  $row['linea'],
            ],[
                'slug' => str_replace(" ", '-', strtolower($row['linea'])),
            ]);

            $type->lines()->syncWithoutDetaching([$line->id]);
     
       
      
           $tejido = Weave::firstOrCreate([
               'name' => $row['tejido']
           ],[
                'slug' => str_replace(" ", '-', strtolower($row['tejido'])),
           ]);

           $line->weaves()->syncWithoutDetaching([$tejido->id]);
       

        $color = Color::firstOrCreate([
           
            'code' => $row['codigo'],
        ],
            [
                'color' => $row['color'],
            ]
        );

        $variant = Sunblind::firstOrCreate(
            ['name' => $row['modelo']],
            [
                'slug' => str_replace(" ", '-',$row['modelo']),
                'price' => $row['precio'],
                'weave_id'=> $tejido->id,
                'line_id' => $line->id,
                'type_id' => $type->id,
            ]      
        );

       
            $manufacturer = Manufacturer::firstOrCreate([
                'name' => $row['fabricante']
            ]);
            
            $variant->manufacturers()->syncWithoutDetaching([$manufacturer->id]);
        // $variant->line_id = $line->id


        $variant->colors()->syncWithoutDetaching([$color->id]);
       
    }
}
 



   public function rules(): array
   {
       return [
           '*.tipo' => ['required', 'string'],
           '*.linea' => ['nullable', 'string'],
           '*.tejido' => ['nullable', 'string'],
           '*.fabricante' => ['nullable','string'],
           '*.codigo' => ['nullable','string'],
           '*.color' => ['nullable'],
           '*.modelo' => ['required','string'],
           '*.precio' => ['nullable','numeric','min:0'],
       ];
   }
  
}

