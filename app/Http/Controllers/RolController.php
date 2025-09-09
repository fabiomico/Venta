<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions', 'users')->get();
        $permissions = Permission::all();

        return view('rol.rol', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('rol.index')->with('success', 'Rol creado correctamente');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('rol.index')->with('success', 'Rol actualizado correctamente');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Administrador') {
            return redirect()->route('rol.index')->with('error', 'No puedes eliminar el rol Administrador');
        }

        $role->delete();
        return redirect()->route('rol.index')->with('success', 'Rol eliminado correctamente');
    }
}
