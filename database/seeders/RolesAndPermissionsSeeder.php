<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'profile.destroy']);
        Permission::create(['name' => 'profile.update']);

        // Crear permisos
        Permission::create(['name' => 'clients']);
        Permission::create(['name' => 'createClient']);
        Permission::create(['name' => 'saveClient']);
        Permission::create(['name' => 'showClient']);
        Permission::create(['name' => 'deleteClient']);
        Permission::create(['name' => 'updateClient']);
        Permission::create(['name' => 'loansClient']);
        
        
        Permission::create(['name' => 'portafolios']);
        Permission::create(['name' => 'createPortafolio']);
        Permission::create(['name' => 'savePortafolio']);
        Permission::create(['name' => 'deletePortafolio']);
        Permission::create(['name' => 'showPortafolio']);
        Permission::create(['name' => 'updatePortafolio']);


        Permission::create(['name' => 'loans']);
        Permission::create(['name' => 'createLoan']);
        Permission::create(['name' => 'saveLoan']);
        Permission::create(['name' => 'deleteLoan']);
        Permission::create(['name' => 'showLoan']);
        Permission::create(['name' => 'updateLoan']);


        Permission::create(['name' => 'payments']);
        Permission::create(['name' => 'createPayment']);
        Permission::create(['name' => 'savePayment']);
        Permission::create(['name' => 'showPayment']);
        Permission::create(['name' => 'deletePayment']);

        // Permissions Admin
        $permissionAdmin = [
            'clients',
            'profile.update',
            'profile.destroy',
            'createClient',
            'saveClient',
            'showClient',
            'deleteClient',
            'updateClient',
            'loansClient',
            'portafolios',
            'createPortafolio',
            'savePortafolio',
            'deletePortafolio',
            'showPortafolio',
            'updatePortafolio',
            'loans',
            'createLoan',
            'saveLoan',
            'deleteLoan',
            'showLoan',
            'updateLoan',
            'payments',
            'createPayment',
            'savePayment',
            'showPayment',
            'deletePayment',
        ];

        // Crear roles y asignar permisos
        $roleCobrador = Role::create(['name' => 'Cobrador']);
        $roleCobrador->givePermissionTo('payments');

        $roleMaster = Role::create(['name' => 'Master'])->syncPermissions($permissionAdmin);

        $roleAdmin = Role::create(['name' => 'Admin'])->syncPermissions($permissionAdmin);
    }
}
