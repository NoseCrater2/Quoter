<?php

namespace App\Imports;

use App\Line;
use App\Motorization;
use App\MotorizationType;
use App\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MotorizationImport implements WithHeadingRow, ToCollection, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $typeM = null;
            if($row->has('tipo') && $row['tipo']){
            $type = Type::firstOrCreate([
                'name' => $row['tipo'],
            ]);

            if($row->has('motorizacion') && $row['motorizacion']){
                $typeM = MotorizationType::firstOrCreate([
                    'name' => $row['motorizacion'],
                ],
                ['slug' => $row['motorizacion']]  
            );
            }
            $manufacturer = Line::firstOrCreate([
                'name' =>  $row['fabricante'],
            ],[
                'name' =>  $row['fabricante'],
                'slug' => str_replace(" ", '-', mb_strtolower($row['fabricante'])),
            ]);

            $motorization = Motorization::firstOrCreate(
                [
                    'code' => $row['codigo'],
                    'motorization_type_id' => $typeM ==! null?$typeM->id:null,
                    'line_id' => $manufacturer->id,
                ],
                [
                    'canvas' => $row->has('lienzo') && $row['lienzo']?$row['lienzo']:0,
                    'system' => $row->has('sistema') && $row['sistema']?$row['sistema']:null,
                    'width' => $row->has('ancho') && $row['ancho']?$row['ancho']:0,
                    'height' => $row->has('alto') && $row['alto']?$row['alto']:0,
                    'price'=> $row['precio'],
                    'via' => $row->has('via') && $row['via']?$row['via']:0,
                    'motorization_type_id' => $typeM ==! null?$typeM->id:null,
                    'line_id' => $manufacturer->id,
                    'type_id' => $type->id,
                ]
            );
        }
        }
    }

    public function rules(): array
    {
        return [
            'codigo' => ['nullable'],
            'lienzo' => ['min:0', 'numeric'],
            'sistema' => ['nullable', 'string'],
            'ancho' => ['numeric', 'min:0'],
            'alto' => ['numeric', 'min:0'],
            'precio' => ['numeric', 'min:0'],
            'via' => ['numeric', 'min:0'],
            'tipo' => ['string'],
            'motorizacion' => ['string', 'nullable'],
            'fabricante' => ['string'],
        ];
    }


}
