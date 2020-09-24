<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
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
        

       
        


        // create roles and assign created permissions

        // this can be done as separate statements
        
        $role = Role::create(['name' => 'Invitado']);
        $role->givePermissionTo('Ver información personal');
        $role->givePermissionTo('Editar información personal');
        
        // or may be done by chaining
        Role::create(['name' => 'Distribuidor']);
        $role->givePermissionTo('Ver información personal');
        $role->givePermissionTo('Editar información personal');
        
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(Permission::all());
        

    }
}
