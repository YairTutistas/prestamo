<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clients;
use App\Models\Companies;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Yair Tutistas',
            'email' => 'prueba@yopmail.com',
            'password' => Hash::make('123456'),
        ]);

        $user->syncRoles('Admin');

        User::factory()->count(50)->create();
        Companies::factory()->count(1)->create();
        Clients::factory()->count(150)->create();
    }
}
