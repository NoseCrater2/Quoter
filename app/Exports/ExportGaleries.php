<?php

namespace App\Exports;

use App\Gallery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportGaleries implements FromQuery, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Gallery::query()
        ->select('galleries.model','t.name','galleries.price','c.color')
        ->leftJoin('color_gallery as cg','galleries.id','=','cg.gallery_id')
        ->leftJoin('colors as c','cg.color_id','=','c.id')
        ->join('types as t', 'galleries.type_id','=','t.id');

    }
    public function headings(): array
    {
        return ['Modelo', 'Tipo','Precio', 'Color'];
    }

    public function columnWidths(): array
    {
        return[
            'A' => 35,
            'b' => 30,
            'c' => 10,
            'd' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
