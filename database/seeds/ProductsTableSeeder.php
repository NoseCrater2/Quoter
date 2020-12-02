<?php

use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create(
            [
                'name' => 'PERSIANAS',
                'slug' => 'PERSIANAS',
                'description' => 'Descubre la más amplia gama de
                texturas y colores de todo el mercado nacional
                para el recubrimiento de ventanas',
            ],
        );
        Product::create(
            [
                'name' => 'CORTINAS',
                'slug' => 'CORTINAS',
                'description' => 'Contamos con una extensa línea
                de cortinas para la decoración de tu hogar u oficina',
            ],
        );
        Product::create(
            [
                'name' => 'TOLDOS',
                'slug' => 'TOLDOS',
                'description' => 'Los toldos de Rollux crean un
                ambiente fresco y confortable en el exterior, en
                cualquier momento del día',

            ],   
        );
    }
}
