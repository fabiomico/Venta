<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica si no hay usuarios en la base de datos
        if (User::count() === 0) {
            // Crear el usuario Admin
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin1234'), // Asegúrate de usar una contraseña segura
            ]);

            // Crear o obtener el rol 'Administrador'
            $role = Role::firstOrCreate(['name' => 'Administrador']);

            // Asignar el rol de administrador al usuario
            $admin->assignRole($role);
        }
    }
}
