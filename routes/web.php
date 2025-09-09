<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\DashboardControoler;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->get('/routes-list', function () {
    $routes = collect(Route::getRoutes())
        ->filter(function ($route) {
            $name = $route->getName();

            return $route->methods()[0] === 'GET' // solo GET
                && empty($route->parameterNames()) // sin parámetros
                && $name !== null                  // con nombre
                && (
                    $name === 'Inicio'             // excepción dashboard
                    || in_array($name, ['Cliente', 'Empresa', 'Perfil']) // rutas sin .index
                    || str_ends_with($name, '.index') // rutas index
                );
        })
        ->map(function ($route) {
            $name = $route->getName();

            // Categoría dinámica
            $category = 'Otras';
            if ($name === 'Inicio') {
                $category = 'Dashboard';
            } elseif (in_array($name, ['Cliente', 'Empresa', 'Perfil'])) {
                $category = $name; // Usamos el nombre directo
            } elseif (str_contains($name, '.')) {
                $category = ucfirst(strtok($name, '.')); // Ej: Ventas.index -> Ventas
            }

            return [
                'uri' => $route->uri(),
                'name' => $name,
                'url' => route($name),
                'category' => $category,
            ];
        })
        ->values();

    return response()->json($routes);
})->name('routes.list');


//dashboard
Route::get('/inicio', [DashboardControoler::class, 'index'])->name('Inicio')->middleware(['auth', 'verified']);

//cliente
Route::get('/cliente', [ClienteController::class, 'index'])->name('Cliente');
Route::get('clientes/fetch', [ClienteController::class, 'fetch'])->name('clientes.fetch');
Route::post('/clientes/store', [ClienteController::class, 'store'])->name('clientes.store');
Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::put('/clientes/{id}/delete', [ClienteController::class, 'marcarBorrado'])->name('clientes.borrar');

//empresa
Route::get('/empresa', [EmpresaController::class, 'index'])->name('Empresa');
Route::get('empresa/fetch', [EmpresaController::class, 'fetch'])->name('empresa.fetch');
Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('empresa.store');
Route::put('empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
Route::get('/empresa/{id}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');

//sucursales
Route::get('sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
Route::get('sucursales/fetch', [SucursalController::class, 'fetch'])->name('sucursales.fetch');

Route::post('sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
Route::put('sucursales/{id}', [SucursalController::class, 'update'])->name('sucursales.update');
Route::delete('sucursales/{id}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');

//perfil
Route::get('/perfil', [PerfilController::class, 'index'])->name('Perfil');
Route::patch('/profile/update', [PerfilController::class, 'update'])->name('profile.update');
Route::patch('/profile/password', [PerfilController::class, 'updatePassword'])->name('profile.password');
Route::delete('/user/avatar/reset', [PerfilController::class, 'resetAvatar'])
    ->name('user.resetAvatar')
    ->middleware('auth');


require __DIR__ . '/auth.php';
