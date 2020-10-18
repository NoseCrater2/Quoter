<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Invitado']);
        $role->givePermissionTo('Ver información personal');
        $role->givePermissionTo('Editar información personal');
        
        // or may be done by chaining
        Role::create(['name' => 'Distribuidor']);
        $role->givePermissionTo('Ver información personal');
        $role->givePermissionTo('Editar información personal');
        
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(Permission::all());

        User::find(1)->assignRole('Administrador');
    }
}
