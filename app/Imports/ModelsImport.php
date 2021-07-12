<?php

namespace App\Imports;

use App\Variant;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;

use Throwable;

class ModelsImport implements 
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        Variant::updateOrCreate(
            ['name' => $row['nombre']],
            ['price' => $row['precio']]
        );
    }

    public function rules(): array
    {
        return [
            '*.nombre' => ['required', 'string'],
            '*.precio' => ['required', 'numeric', 'min:1'],
        ];
    }
}
