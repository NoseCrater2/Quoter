<?php

namespace App\Imports;

use App\Blind;
use Maatwebsite\Excel\Concerns\ToModel;

class BlindsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       
    }
}
