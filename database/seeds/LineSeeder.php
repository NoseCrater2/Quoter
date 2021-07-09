<?php

use Illuminate\Database\Seeder;
use App\Line; 
use Illuminate\Support\Facades\DB;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Line::create(['name' => 'BLACKOUT']); //1
        Line::create(['name' => 'DECORATIVO']); //2
        Line::create(['name' => 'DIMOUT']); //3
        Line::create(['name' => 'EXTERIOR']); //4
        Line::create(['name' => 'NO']); //5
        Line::create(['name' => 'PVC']); //6
        Line::create(['name' => 'SCREEN']); //7
        Line::create(['name' => 'TELA SIN PORTATELA']); //8
        Line::create(['name' => 'TELA CON PORTATELA']); //9
        Line::create(['name' => 'TRASLUCIDO']); //10

        Line::where('id','=',3)->get()[0]->manufacturers()->sync([10,11,12,2,6,3,5]);
        Line::where('id','=',1)->get()[0]->manufacturers()->sync([10,11,12,2,6,3]);
        Line::where('id','=',7)->get()[0]->manufacturers()->sync([10,11,12,4,7,2,6,3]);
        Line::where('id','=',10)->get()[0]->manufacturers()->sync([10,11,12,2,6,3,5]);

    }
}
