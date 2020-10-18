<?php

use Illuminate\Database\Seeder;
use App\Type;
use App\Manufacturer;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['name' => 'Celular Sistema Cordon']);//NO 1
        Type::create(['name' => 'Celular Sistema Muelle']);//NO 2
        Type::create(['name' => 'Celular Dia&Noche']);//NO 3
        Type::create(['name' => 'Enrollable']); // 4
        Type::create(['name' => 'Flex Ballet']);//NO 5
        Type::create(['name' => 'Horizontal De Alumnio 1']);//NO 6
        Type::create(['name' => 'Horizontal De Alumnio 2']);//NO 7
        Type::create(['name' => 'Horizontal De Madera 2']);//NO 8
        Type::create(['name' => 'Panel Japonés']); //9
        Type::create(['name' => 'Romana']); //10
        Type::create(['name' => 'Romantic']);//NO 11
        Type::create(['name' => 'Sheer']);// 12
        Type::create(['name' => 'Triple Shade/Shangri La']);//NO 13
        Type::create(['name' => 'Vertical']);// 14

        Type::where('name','like','Celular%')->get()[0]->lines()->sync([5]);
        Type::where('name','like','Flex%')->get()[0]->lines()->sync([5]);
        Type::where('name','like','Horizontal%')->get()[0]->lines()->sync([5]);
        Type::where('name','like','Romantic%')->get()[0]->lines()->sync([5]);
        Type::where('name','like','Triple%')->get()[0]->lines()->sync([5]);

        Type::where('name','like','Enrollable%')->get()[0]->lines()->sync([7,2,1,4]);

        Type::where('name','like','Panel%')->get()[0]->lines()->sync([7,2,1]);

        Type::where('name','like','Romana%')->get()[0]->lines()->sync([7,2,1]);

        Type::where('name','like','Sheer%')->get()[0]->lines()->sync([10,3]);

        Type::where('name','like','Vertical%')->get()[0]->lines()->sync([6,8,9]);

        $m = Manufacturer::where('short_name','=','NV')->get()[0];
        $m->type_id = 13;
        $m->save();
        $m = Manufacturer::where('short_name','=','TS')->get()[0];
        $m->type_id = 13;
        $m->save();
        $m = Manufacturer::where('short_name','=','VX')->get()[0];
        $m->type_id = 13;
        $m->save();

    }
}
