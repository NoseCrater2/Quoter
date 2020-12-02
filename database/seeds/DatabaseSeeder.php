<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::flushEventListeners();

        $this->truncateTables([
            'products',
            'users',
            'products',
            'permissions',
            'roles',
            // 'manufacturers',
            // 'lines',
            'types'
          ]);
          $this->call([
            ProductsTableSeeder::class,
            UsersTableSeeder::class,
            PermissionsSeeder::class,
            RolesTableSeeder::class,
            // ManufacturerSeeder::class,
            // LineSeeder::class,
            TypeSeeder::class,
          ]);
          DB::statement('SET FOREIGN_KEY_CHECKS = 1');  
    }

    protected function truncateTables(array $tables){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($tables as $table) {
          DB::table($table)->truncate();
        }
        
      }


}
