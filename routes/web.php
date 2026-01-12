<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DashboardController;

// RUTA PRINCIPAL
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
    // Roles
    Route::view('roles', 'roles')->name('roles');

    // Usuarios
    Route::view('usuarios', 'usuarios.index')->name('usuarios.index');
    Route::view('usuarios/{id}', 'usuarios.mostrar')->name('usuarios.mostrar');

    // Tipo de Clientes
    Route::view('tipo-clientes', 'tipo-clientes.index')->name('tipo-clientes.index');
    Route::view('tipo-clientes/{id}', 'tipo-clientes.mostrar')->name('tipo-clientes.mostrar');

    // Clientes
    Route::view('clientes', 'clientes.index')->name('clientes.index');
    Route::view('clientes/crear', 'clientes.crear')->name('clientes.crear');
    Route::view('clientes/{id}', 'clientes.mostrar')->name('clientes.mostrar');

    // Tipo de Trámites
    Route::view('tipo-tramites', 'tipo-tramites.index')->name('tipo-tramites.index');
    Route::view('tipo-tramites/{id}', 'tipo-tramites.mostrar')->name('tipo-tramites.mostrar');

    // Trámites
    Route::view('tramites', 'tramites.index')->name('tramites.index');
    Route::view('tramites/crear', 'tramites.crear')->name('tramites.crear');
    Route::view('tramites/{id}', 'tramites.mostrar')->name('tramites.mostrar');

    // PDFs
    Route::get('/tramites/pdf/{id}', [PDFController::class, 'reciboPDF'])->name('tramites.pdf');
    Route::get('/reportes/pdf/{tipo}', [PDFController::class, 'reportePDF'])->name('reportes.pdf');

    // Reportes
    Route::view('reportes', 'reportes.index')->name('reportes.index');

    // Bitácora
    Route::view('bitacora', 'bitacora.index')->name('bitacora');
    Route::view('bitacora/{id}', 'bitacora.mostrar')->name('bitacora.mostrar');

});

require __DIR__.'/auth.php';
