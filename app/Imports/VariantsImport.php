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
        //  $rowIndex = $row->getIndex();
         $row      = $row->toArray();

        $type = Type::firstOrCreate([
            'name' => $row[0],
        ]);

        
       $line =  Line::firstOrCreate([
            'name' =>  $row[1],
        ]);

        $manufacturer = Manufacturer::firstOrCreate([
            'name' => $row[7]
        ]);

        $color = Color::firstOrCreate([
            'color' => $row[4] 
        ]);

        $variant = Variant::firstOrCreate(
            ['name' => $row[3]],
            [
                'line_id' => $line->id,
                'type_id' => $type->id,
            ]      
        );

        // $variant->line_id = $line->id


        $variant->colors()->syncWithoutDetaching([$color->id]);
        $variant->manufacturers()->syncWithoutDetaching([$manufacturer->id]);

    }

}
