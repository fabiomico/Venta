<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    public function index()
    {
        // vista única con tabla + modales (como venías trabajando)
        return view('sucursal.sucursal');
    }

    /**
     * Listado paginado (JSON) con búsqueda.
     * GET /sucursales/fetch?search=...&page=...
     */
    public function fetch(Request $request)
    {
        $search  = $request->input('search', '');
        $perPage = (int) ($request->input('perPage', 10) ?: 10);
        $page    = (int) ($request->input('page', 1) ?: 1);
        $empresaId = $request->input('empresa_id'); // opcional para filtrar por empresa

        $query = Sucursal::with('empresa')
            ->where('estado', '!=', 0);

        if ($empresaId) {
            $query->where('empresa_id', $empresaId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        $sucursales = $query->orderByDesc('id')
                            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($sucursales);
    }

    /**
     * Crear sucursal (JSON)
     * POST /sucursales
     */
    public function store(Request $request)
    {
        $empresaId = auth()->User()->id_empresa; // ← del usuario logueado

        $validated = $request->validate([
            'nombre'      => 'required|string|max:120',
            'telefono'    => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:120',
            'direccion'   => 'nullable|string|max:200',
            'ciudad'      => 'nullable|string|max:100',
            'departamento'=> 'nullable|string|max:100',
            'activa'      => 'boolean',
        ]);

        $sucursal = Sucursal::create(array_merge($validated, [
            'empresa_id' => $empresaId,   // se asigna automático
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Sucursal creada correctamente',
            'sucursal' => $sucursal
        ]);
    }

    /**
     * Actualizar sucursal (JSON)
     * PUT /sucursales/{id}
     */
    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::find($id);
        if (!$sucursal || (int)$sucursal->estado === 0) {
            return response()->json(['status' => 'error', 'message' => 'Sucursal no encontrada'], 200);
        }

        $empresaId = $request->input('empresa_id', $sucursal->empresa_id);

        $validator = Validator::make(
            array_merge($request->all(), ['empresa_id' => $empresaId]),
            [
                'empresa_id'  => ['required','exists:empresas,id'],
                'codigo'      => [
                    'required','string','max:30',
                    Rule::unique('sucursales','codigo')
                        ->ignore($sucursal->id)
                        ->where(fn($q)=>$q->where('empresa_id',$empresaId))
                ],
                'nombre'      => ['required','string','max:120'],
                'telefono'    => ['nullable','string','max:50'],
                'email'       => ['nullable','email','max:120'],
                'direccion'   => ['nullable','string','max:200'],
                'ciudad'      => ['nullable','string','max:100'],
                'departamento'=> ['nullable','string','max:100'],
                'estado'      => ['nullable','integer','in:0,1'],
            ],
            [],
            [
                'empresa_id'  => 'empresa',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 200);
        }

        $sucursal->update([
            'empresa_id'   => $empresaId,
            'nombre'       => $request->nombre,
            'telefono'     => $request->telefono,
            'email'        => $request->email,
            'direccion'    => $request->direccion,
            'ciudad'       => $request->ciudad,
            'departamento' => $request->departamento,
            'estado'       => $request->filled('estado') ? (int)$request->estado : $sucursal->estado,
        ]);

        return response()->json([
            'status'   => 'success',
            'message'  => 'Sucursal actualizada correctamente',
            'sucursal' => $sucursal->load('empresa'),
        ], 200);
    }

    /**
     * Marcar como borrado (estado = 0) (JSON)
     * DELETE /sucursales/{id}  o POST /sucursales/{id}/borrar
     */
    public function marcarBorrado(Request $request, $id)
    {
        $sucursal = Sucursal::find($id);
        if (!$sucursal) {
            return response()->json(['status' => 'error', 'message' => 'Sucursal no encontrada'], 200);
        }

        $sucursal->estado = 0; // borrado lógico
        $sucursal->save();

        return response()->json(['status' => 'success', 'message' => 'Sucursal eliminada'], 200);
    }

    /**
     * Si quieres usar DELETE /sucursales/{id}
     */
    public function destroy($id)
    {
        return $this->marcarBorrado(request(), $id);
    }
}
