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
        // Perfil
        Permission::create(['name' => 'profile.destroy']);
        Permission::create(['name' => 'profile.update']);
        Permission::create(['name' => 'users']);

        // Crear permisos clientes
        Permission::create(['name' => 'clients']);
        Permission::create(['name' => 'createClient']);
        Permission::create(['name' => 'saveClient']);
        Permission::create(['name' => 'showClient']);
        Permission::create(['name' => 'deleteClient']);
        Permission::create(['name' => 'updateClient']);
        Permission::create(['name' => 'loansClient']);
        
        // Crear permisos portafolios
        Permission::create(['name' => 'portafolios']);
        Permission::create(['name' => 'createPortafolio']);
        Permission::create(['name' => 'savePortafolio']);
        Permission::create(['name' => 'deletePortafolio']);
        Permission::create(['name' => 'showPortafolio']);
        Permission::create(['name' => 'updatePortafolio']);

        // Crear permisos prestamos
        Permission::create(['name' => 'loans']);
        Permission::create(['name' => 'createLoan']);
        Permission::create(['name' => 'saveLoan']);
        Permission::create(['name' => 'deleteLoan']);
        Permission::create(['name' => 'showLoan']);
        Permission::create(['name' => 'updateLoan']);
        Permission::create(['name' => 'pendingLoan']);

        // Crear permisos pagos
        Permission::create(['name' => 'payments']);
        Permission::create(['name' => 'createPayment']);
        Permission::create(['name' => 'savePayment']);
        Permission::create(['name' => 'showPayment']);
        Permission::create(['name' => 'deletePayment']);

        // Crear permisos companies
        Permission::create(['name' => 'company']);
        Permission::create(['name' => 'createCompany']);
        Permission::create(['name' => 'saveCompany']);

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
            'pendingLoan',
            'company',
            'createCompany',
            'saveCompany',
        ];

        $permissionCollector = [
            'payments',
            'saveLoan',
            'loans',
            'clients'
        ];

        // Crear roles y asignar permisos
        $roleCobrador = Role::create(['name' => 'Cobrador'])->syncPermissions($permissionCollector);

        $roleMaster = Role::create(['name' => 'Master'])->syncPermissions(Permission::all());

        $roleAdmin = Role::create(['name' => 'Admin'])->syncPermissions($permissionAdmin);
    }
}
