<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'password'=>bcrypt('10203040'),
            'rol_id'=>1
        ])->assignRole('Superusuario');

        /* $id=1;

        while ($id <= 100) {

            $role=Role::inRandomOrder()->first();

            User::factory()->create([
                'rol_id'=>$role->id
            ])->assignRole($role->name);
            $id++;
        } */
    }
}
