<?php

use Illuminate\Database\Seeder;
use App\Control;

class ControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Control::create([
            'code' => 'CTRLMON',
            'channel' => '1',
            'description' => 'Control Monocanal RF Movil',
            'manufacturer' => 'B-MIGHTY',
            'price' => 465.29,
        ]);

        Control::create([
            'code' => 'CTRLMUL5',
            'channel' => '5',
            'description' => 'Control Multicanal RF Movil',
            'manufacturer' => 'B-MIGHTY',
            'price' => 676.79,
        ]);

        Control::create([
            'code' => 'CTRLMUL6',
            'channel' => '6',
            'description' => '',
            'manufacturer' => 'B-MIGHTY',
            'price' => 0,
        ]);

        Control::create([
            'code' => 'CTRLMUL15',
            'channel' => '15',
            'description' => 'Control Multicanal RF Movil',
            'manufacturer' => 'B-MIGHTY',
            'price' => 465.29,
        ]);

        Control::create([
            'channel' => 'SMART CONTROL',
            'description' => 'Smart Control',

            'price' => 0,
        ]);

        Control::create([
            'code' => 'CTRLMON-S',
            'channel' => '1',
            'description' => 'Control Monocanal 1600 RF',
            'manufacturer' => 'B-MIGHTY',
            'price' => 563.99,
        ]);

        Control::create([
            'code' => 'CTRLMUL-15-S',
            'channel' => '15',
            'description' => 'Control Multicanal 1602 RF',
            'manufacturer' => 'B-MIGHTY',
            'price' => 676.79,
        ]);

        Control::create([
            'code' => 'CTRLMON-90',
            'channel' => '1',
            'description' => 'Control Monocanal 90 RF',
            'manufacturer' => 'B-MIGHTY',
            'price' => 155.10,
        ]);

        Control::create([
            'code' => 'CTRLMON-250',
            'channel' => '1',
            'description' => 'Control Monocanal 250 RF',
            'manufacturer' => 'B-MIGHTY',
            'price' => 155.10,
        ]);
    }
}
