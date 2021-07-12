<?php

namespace App\Exports;

use App\Variant;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VariantsExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Variant::select('name', 'price')->get();
    }

    public function headings(): array
    {
        return ['Nombre', 'Precio'];
    }

    public function columnWidths(): array
    {
        return[
            'A' => 50,
            'b' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

}
