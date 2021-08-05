<?php

namespace App\Imports;

use App\Type;
use App\Line;
use App\Color;
use App\Weave;
use App\Subweave;
use App\Variant;
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
       if(isset($rows[0]) && $rows[0]->has('tipo')){

           $type = Type::firstOrCreate([
               'name' => $rows[0]['tipo'],
           ]);

           $type->variants()->delete();

           $type->lines()->detach();
           $type->weaves()->detach();

       }


       foreach ($rows as $row) {
           $weave = null;
           $subweave = null;

           if($row->has('tipo') && $row['tipo']){
           $type = Type::firstOrCreate(['name' => $row['tipo'],
           ],[
                   'slug' => str_replace(" ", '-', mb_strtolower($row['tipo'])),
           ]);


               $line =  Line::firstOrCreate([
                   'name' =>  $row['linea'],
               ],[
                   'slug' => str_replace(" ", '-', mb_strtolower($row['linea'])),
               ]);

               $type->lines()->syncWithoutDetaching([$line->id]);

            if($row->has('modelo') && $row['modelo']){

                $subweave = Subweave::firstOrCreate([
                    'name' => $row['modelo'],
                    'line_id' => $line->id,
                    'type_id' => $type->id
                ],[
                    'name' => $row['modelo'],
                    'slug' => str_replace(' ', '-', mb_strtolower($row['modelo'])),
                    'description' =>  $row->has('descripcion')&&$row['descripcion']?$row['descripcion']:null,
                    'line_id' => $line->id,
                    'type_id' => $type->id
                ]);

            }

               if($row->has('tejido') && $row['tejido']){

                   $weave = Weave::firstOrCreate([
                       'name' => $row['tejido']
                   ],[
                       'slug' => str_replace(' ', '-', mb_strtolower($row['tejido']))
                   ]);

                //    $type->weaves()->syncWithoutDetaching([$weave->id]);
                   if($subweave != null){
                       $subweave->weaves()->syncWithoutDetaching([$weave->id]);
                   }
               }



               $variant = Variant::firstOrCreate(
                   [
                       'name' => $row['producto'],
                       'weave_id' => $weave != null ? $weave->id : null,
                       'line_id' => $line->id,
                       'type_id' => $type->id,
                       'subweave_id' => $subweave->id,
                   ],
                   [
                       'slug' =>  preg_replace("[\W]", "-", $row['modelo']),
                       'width' => $row->has('ancho') && $row['ancho']?floatval(preg_replace("[\,]",'.',$row['ancho'])):1,
                       'price' => $row->has('precio')?$row['precio']:0,
                       'rotate' =>$row->has('rotacion')?$row['rotacion']:0,
                       'weight' => $row->has('peso')?$row['peso']:null,
                        'polyester' => $row->has('polyester')?$row['polyester']:null,
                        'acrylic' => $row->has('acrilico')?$row['acrilico']:null,
                        'pvc' => $row->has('pvc')?$row['pvc']:null,
                        'fiberglass' => $row->has('fiberglass')?$row['fiberglass']:null,
                        'linen' => $row->has('lino')?$row['lino']:null,
                        'pet' => $row->has('pet')?$row['pet']:null,
                        'whiteback' => $row->has('whiteback')?$row['whiteback']:null,
                       'weave_id' => $weave != null ? $weave->id : null,
                       'line_id' => $line->id,
                       'type_id' => $type->id,
                       'subweave_id' => $subweave->id,
                   ]
               );


                $color = Color::firstOrCreate([
                    'code' => $row['codigo'],
                    'color' => $row['color'],
                    'variant_id' => $variant->id

                ],
                    [
                        'code' => $row['codigo'],
                        'color' => $row['color'],
                        'variant_id' => $variant->id
                    ]
                );

            }
       }
   }



      public function rules(): array
      {
          return [
           //    '*.tipo' => ['string'],
           //    '*.linea' => ['nullable', 'string'],
           //    '*.fabricante' => ['nullable','string'],
           //    '*.codigo' => ['nullable','string'],
           //    '*.codigo_cortinero' => ['numeric'],
           //    '*.ancho_cortinero' => ['nullable','numeric', 'min:0'],
           //    '*.color' => ['nullable'],
           //    '*.rotacion' => ['nullable','in:0,1'],
           //    '*.modelo' => ['required','string'],
           //    '*.ancho' => ['nullable','numeric', 'min:0'],
           //    '*.terminado' => ['nullable','string'],
           //    '*.tira' => ['nullable','numeric', 'min:0'],
           //    '*.precio' => ['nullable','numeric','min:0'],
           //    '*.peso' => ['nullable','numeric','min:0'],
           //    '*.descripcion' => ['nullable','string'],
           //    '*.acabado' => ['nullable','string'],
           //    '*.peso' => ['nullable','numeric','min:0'],
           //    '*.precio_techo' => ['nullable','numeric','min:0'],
           //    '*.precio_pared' => ['nullable','numeric','min:0'],
           //    '*.precio_pared_extendido' => ['nullable','numeric','min:0'],
           //    '*.precio_pared_doble' => ['nullable','numeric','min:0'],
           //    '*.precio_techo_pared' => ['nullable','numeric','min:0'],
           //    '*.precio_doble' => ['nullable','numeric','min:0'],
          ];
      }

}

