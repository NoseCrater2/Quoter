<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'Ver información personal']);
        Permission::create(['name' => 'Editar información personal']);
    }
}
