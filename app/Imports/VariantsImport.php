<?php

namespace App\Imports;

use App\Variant;
use App\Type;
use App\Line;
use App\Color;
use App\Manufacturer;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class VariantsImport implements OnEachRow
{
    
   
    public function onRow(Row $row)
    {
         $rowIndex = $row->getIndex();
         $row      = $row->toArray();

        Type::firstOrCreate([
            'name' => $row[0],
        ]);

        
       $line =  Line::firstOrCreate([
            'name' =>  $row[1],
        ]);

        $line->variants()->firstOrCreate([
            'name' =>  $row[3],
        ]);


        Color::firstOrCreate([
            'color' => $row[4],
        ]);

        Manufacturer::firstOrCreate([
            'name' => $row[5],
        ]);
        //$type->lines()->attach($line->id);

    }

   
    // public function model(array $row)
    // {
    //     return new Variant([
    //         'color' => $row[1],
    //         'max_width' => $row[2],
    //         'max_height' => $row[3],
    //         'rotate' => $row[4],
    //         'price' => $row[5],
    //         'min_width' => $row[6],
    //         'min_height' => $row[7],
    //         'type_id' => $row[8],
    //         'entity_id' => $row[9],
    //     ]);
    // }
}
