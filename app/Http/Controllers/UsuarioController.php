<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('usuario.usuario', compact('roles'));
    }

    // Endpoint JSON para DataTable
    public function getUsers(Request $request)
    {
        $query = User::with('roles');

        // Búsqueda general
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->get();

        return response()->json($users);
    }
}
