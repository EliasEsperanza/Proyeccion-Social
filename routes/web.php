<?php

use App\Http\Controllers\DepartamentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.login');
});

Route::get('/registro', function () {
    return view('registro.registro');
});

Route::get('/proyecto', function () {
    return view('proyecto.publicar-proyecto');
})->name('proyecto');

Route::get('/gestion-proyecto', function () {
    return view('gestionProyectos.gestionProyectos');
});

Route::get('/crear', function () {
    return view('usuarios.crearUsuario');
})->name('crear');

Route::get('/ExportDptExcel', [DepartamentoController::class, 'exportarAllDepartamentos_Excel'])->name('Departamaento.Exportexcel');
Route::get('/ExportDptPdf', [DepartamentoController::class, 'exportarAllDepartamentos_Pdf'])->name('Departamaento.ExportPdf');


Route::get('/tests', function () {
    return view('Kev.Tests');
});

Route::get('/usuarios', function () {
    return view('usuarios.listaUsuario');
})->name('usuarios');