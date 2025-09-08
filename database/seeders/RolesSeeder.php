<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Recepcionista']);

        // Permisos de Ventas
        Permission::create(['name' => 'ventas.ver', 'descripcion'=>'Permite ver las ventas']);
        Permission::create(['name' => 'ventas.crear', 'descripcion'=>'Permite crear una venta']);
        Permission::create(['name' => 'ventas.editar', 'descripcion'=>'Permite editar una venta']);
        Permission::create(['name' => 'ventas.eliminar', 'descripcion'=>'Permite eliminar una venta']);

        // Permisos de Compras
        Permission::create(['name' => 'compras.ver', 'descripcion'=>'Permite ver las compras']);
        Permission::create(['name' => 'compras.crear', 'descripcion'=>'Permite crear una compra']);
        Permission::create(['name' => 'compras.editar', 'descripcion'=>'Permite editar una compra']);
        Permission::create(['name' => 'compras.eliminar', 'descripcion'=>'Permite eliminar una compra']);

        // Permisos de Inventario
        Permission::create(['name' => 'inventario.ver', 'descripcion'=>'Permite ver el inventario']);
        Permission::create(['name' => 'inventario.crear', 'descripcion'=>'Permite crear un producto en el inventario']);
        Permission::create(['name' => 'inventario.editar', 'descripcion'=>'Permite editar un producto en el inventario']);
        Permission::create(['name' => 'inventario.eliminar', 'descripcion'=>'Permite eliminar un producto en el inventario']);

        // Permisos de Usuarios
        Permission::create(['name' => 'usuarios.ver', 'descripcion'=>'Permite ver los usuarios']);
        Permission::create(['name' => 'usuarios.crear', 'descripcion'=>'Permite crear un usuario']);
        Permission::create(['name' => 'usuarios.editar', 'descripcion'=>'Permite editar un usuario']);
        Permission::create(['name' => 'usuarios.eliminar', 'descripcion'=>'Permite eliminar un usuario']);

        // Permisos de Clientes
        Permission::create(['name'=>'Cliente','descripcion'=>'Permite gestionar clientes']);
        Permission::create(['name'=>'clientes.store','descripcion'=>'Permite registrar clientes']);
        Permission::create(['name'=>'clientes.update','descripcion'=>'Permite actualizar clientes']);
        Permission::create(['name'=>'clientes.borrar','descripcion'=>'Permite eliminar clientes']);
    }
}
