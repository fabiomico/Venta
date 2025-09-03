<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('perfil.perfil', compact('user'));
    }
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'paterno' => 'nullable|string|max:255',
            'materno' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|max:800', // Máximo 800KB
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'paterno.max' => 'El apellido paterno no puede tener más de 255 caracteres.',
            'materno.max' => 'El apellido materno no puede tener más de 255 caracteres.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'profile_photo.image' => 'El archivo debe ser una imagen (JPG, PNG, GIF).',
            'profile_photo.max' => 'La imagen no puede superar los 800 KB.',
        ]);

        $user->name = $request->nombre;
        $user->paterno = $request->paterno;
        $user->materno = $request->materno;
        $user->email = $request->email;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('avatars', 'public');
            $user->foto = $path;
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ], [
            'current_password.required' => 'Debe ingresar su contraseña actual.',
            'new_password.required' => 'Debe ingresar la nueva contraseña.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
    public function resetAvatar(Request $request)
    {
        $user = Auth::user();

        // si el usuario tenía una foto guardada en storage/public/avatars
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        // eliminar referencia en la base de datos
        $user->foto = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto de perfil eliminada correctamente',
            'defaultAvatar' => asset('assets/img/avatars/cat4.gif'),
        ]);
    }
}
