<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    public function index()
    {
        return view('empresa.empresa');
    }
    public function edit($id)
    {
        $empresa = Empresa::where('id_user', Auth::id())->findOrFail($id);
        return response()->json($empresa);
    }
    public function fetch(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = 10;
        $page = $request->input('page', 1);

        $user = Auth::user();

        $query = Empresa::with('user')
            ->where('id_user', $user->id); // Solo empresas del usuario autenticado

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('telefono', 'like', "%$search%")
                    ->orWhere('correo', 'like', "%$search%")
                    ->orWhere('nit', 'like', "%$search%")
                    ->orWhere('direccion', 'like', "%$search%");
            });
        }

        $empresas = $query->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($empresas);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $user = Auth::user();

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos_empresas', 'public');
        }

        $empresa = Empresa::create([
            'nombre'   => $request->nombre,
            'telefono' => $request->telefono,
            'correo'   => $request->correo,
            'logo'     => $logoPath,
            'direccion' => $request->direccion,
            'nit'     => $request->nit,
            'id_user'  => $user->id,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Empresa registrada correctamente',
            'empresa' => $empresa
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Empresa no encontrada'
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        // Subida de nuevo logo (opcional)
        if ($request->hasFile('logo')) {
            // eliminar logo anterior si existe
            if ($empresa->logo && Storage::disk('public')->exists($empresa->logo)) {
                Storage::disk('public')->delete($empresa->logo);
            }
            $empresa->logo = $request->file('logo')->store('logos_empresas', 'public');
        }

        $empresa->nombre   = $request->nombre;
        $empresa->telefono = $request->telefono;
        $empresa->correo   = $request->correo;
        $empresa->direccion = $request->direccion;
        $empresa->nit      = $request->nit;
        $empresa->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Empresa actualizada correctamente',
            'empresa' => $empresa
        ], 200);
    }
}
