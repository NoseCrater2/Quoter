<?php

namespace App\Exports;

use App\Motorization;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MotorizationExport implements FromQuery, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Motorization::query()
        ->select('motorizations.code','mt.name as motorizacion','motorizations.system','t.name as tipo','l.name as linea', 'motorizations.canvas', 'motorizations.height','motorizations.width','motorizations.via')
        ->join('motorization_types as mt', 'motorizations.motorization_type_id','=','mt.id')
        ->join('types as t','motorizations.type_id','=','t.id')
        ->join('lines as l','motorizations.line_id','=','l.id');

    }
    public function headings(): array
    {
        return ['Codigo', 'Motorizacion','Sistema','Tipo', 'Linea','Lienzo', 'Alto','Ancho','Via'];
    }

    public function columnWidths(): array
    {
        return[
            'A' => 20,
            'b' => 15,
            'c' => 60,
            'd' => 15,
            'e' => 15,
            'f' => 15,
            'g' => 15,
            'h' => 15,
            'i' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

}