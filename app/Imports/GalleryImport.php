<?php

namespace App\Imports;

use App\Gallery;
use App\Color;
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

class GalleryImport implements WithHeadingRow, ToCollection, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $color = null;
            if($row->has('tipo') && $row['tipo']){
                $type = Type::firstOrCreate([
                    'name' => $row['tipo'],
                ]);

            $gallery = Gallery::firstOrCreate(
                ['model' => $row['modelo'],
                 'type_id' => $type->id,
                ],
                [
                    'price' => $row['precio'],
                    'type_id' =>  $type->id,
                ]
            );

            if($row->has('color') && $row['color']){
                $color = Color::firstOrCreate([
                    'color' => $row['color']
                ]);
                $gallery->colors()->syncWithoutDetaching([$color->id]);
            }


            }
        }
        
    }

    public function rules(): array
    {
        return [
            'tipo' => ['string'],
            'modelo' => ['string'],
            'precio' => ['numeric', 'min:0'],
            'color' => ['string', 'nullable'],
        ];
    }
}
