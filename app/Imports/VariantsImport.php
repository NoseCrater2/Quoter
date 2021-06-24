<?php

namespace App\Imports;

use App\Variant;
use App\Type;
use App\Line;
use App\Color;
use App\Manufacturer;
use App\Weight;
use App\Weave;
use Illuminate\Support\Facades\DB;
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
    if(isset($rows[0]) && $rows[0]->has('tipo')){

        $type = Type::firstOrCreate([
            'name' => $rows[0]['tipo'],
        ]);

        DB::table('variants')->where('type_id', '=', $type->id)->delete();
        $type->lines()->detach();
    }

   
    foreach ($rows as $row) {
        
        $line = null;
        $tejido = null;

        if($row->has('tipo') && $row['tipo']){
        $type = Type::firstOrCreate(['name' => $row['tipo'],
            ],[
                'slug' => str_replace(" ", '-', mb_strtolower($row['tipo'])),
            ]);


       if($row->has('linea') && $row['linea']){

            $line =  Line::firstOrCreate([
                'name' =>  $row['linea'],
                'type_name' => $row['tipo'],
            ],[
                'slug' => str_replace(" ", '-', mb_strtolower($row['linea'])),
                'type_name' => $row['tipo'],
            ]);

            $type->lines()->syncWithoutDetaching([$line->id]);

          
            if($row->has('tejido') && $row['tejido']){
            
            $tejido = Weave::firstOrCreate([
                'name' => $row['tejido']
                ],[
                 'slug' => str_replace(' ', '-', mb_strtolower($row['tejido'])),
                ]);
        
            $line->weaves()->syncWithoutDetaching([$tejido->id]);
        }


       }
       
       
    
        $color = Color::firstOrCreate([
            'code' => $row['codigo'],
            'color' => $row['color'],
        ],
            [
                'color' => $row['color']
            ]
        );

        $variant = Variant::firstOrCreate(
            [
                'name' => $row['modelo'],
                'type_id' => $type->id,
                'line_id' => $line?$line->id:null,
                'weave_id' => $tejido?$tejido->id:null,
            ],
            [
                'slug' =>  preg_replace("[\W]", "-", $row['modelo']),
                'width' => $row->has('ancho') && $row['ancho']?floatval(preg_replace("[\,]",'.',$row['ancho'])):1,
                'finished' => $row->has('acabado') ? $row['acabado'] : null,
                'strip_width' => $row->has('tira') ? $row['tira'] : 0,
                'price' => $row->has('precio')?$row['precio']:0,
                'description' => $row->has('descripcion')?$row['descripcion']:null,
                'rotate' =>$row->has('rotacion')?$row['rotacion']:0,
                'weave_id'=> $tejido != null ? $tejido->id : null,
                'line_id' => $line != null ? $line->id : null,
                'type_id' => $type->id,
            ]      
        );


        if($row->has('fabricante') && $row['fabricante']){
            $manufacturer = Manufacturer::firstOrCreate([
                'name' => $row['fabricante']
            ]);
            
            $variant->manufacturers()->syncWithoutDetaching([$manufacturer->id]);
        }

        $oldColor = $variant->colors->whereStrict('color', $color->color);
       
        if(isset($oldColor[0])){
           if($oldColor[0]->code !== $color->code){
                $variant->colors()->detach($oldColor[0]->id);
                $oldColor[0]->delete();
           }
        }
       
        $variant->colors()->syncWithoutDetaching([$color->id]);

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

   function addZeros($code){
    if($code[strlen($code)-1] == 'T'){
        if(strlen($code) < 12){
         
          return $this->addZeros('0'.$code);
          
        }else{
            return $code;
        }
        
    }else{
        if(strlen($code) < 11){
         return $this->addZeros('0'.$code);
        }else{
            return $code;
        }
    }	
   }
}
