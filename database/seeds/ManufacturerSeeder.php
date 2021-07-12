<?php

use Illuminate\Database\Seeder;
use App\Manufacturer;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        Manufacturer::create(['name' => 'FARZ','short_name'=> '']);//1
        Manufacturer::create(['name' => 'HUNTER DOUGLAS','short_name'=> 'HD']);//2
        Manufacturer::create(['name' => 'KATRINA','short_name'=> 'KTN']);//3
        Manufacturer::create(['name' => 'MESH','short_name'=> 'Mesh']);//4
        Manufacturer::create(['name' => 'MIRAGE','short_name'=> 'MIR']);//5
        Manufacturer::create(['name' => 'NEVALUZ','short_name'=> 'NV']);//6
        Manufacturer::create(['name' => 'PHIFER','short_name'=> 'Phifer']);//7
        Manufacturer::create(['name' => 'SUNWAY','short_name'=> '']);//8
        Manufacturer::create(['name' => 'TECHNOLINE','short_name'=> '']);//9
        Manufacturer::create(['name' => 'TECHNOSHADES','short_name'=> 'TEC']);//10
        Manufacturer::create(['name' => 'TREESHADES','short_name'=> 'TS']);//11
        Manufacturer::create(['name' => 'VERTILUX','short_name'=> 'VX']);//12
    }
}
