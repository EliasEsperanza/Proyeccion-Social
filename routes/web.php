<?php

use App\Http\Controllers\historial_departamentoController;
use App\Http\Controllers\TestsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatDocumentoController;
use App\Http\Controllers\DepartamentoController;

Route::get('/', function () {
    return view('login.login');
});

Route::get('/permisos', function () {
    return view('permisos.gestionpermiso');
})
    ->name('permisos');

Route::get('/registro', function () {
    return view('registro.registro');
});

Route::get('/proyecto', function () {
    return view('proyecto.publicar-proyecto');
})->name('proyecto');

Route::get('/gestion-proyecto', function () {
    return view('gestionProyectos.gestionProyectos');
})->name('gestion-proyecto');

Route::get('/crear', function () {
    return view('usuarios.crearUsuario');
})->name('crear');

Route::get('/usuarios', function () {
    return view('usuarios.listaUsuario');
})->name('usuarios');

Route::get('/layouts', function () {
    return view('layouts.gestion-de-roles');
})->name('roles');

Route::get('/perfil', function () {
    return view('perfil.perfilUsuario');
})
    ->name('perfil');




//departamentos
Route::get('/ExportDptExcel', [DepartamentoController::class, 'exportarAllDepartamentos_Excel'])->name('Departamaento.Exportexcel');
Route::get('/ExportDptPdf', [DepartamentoController::class, 'exportarAllDepartamentos_Pdf'])->name('Departamaento.ExportPdf');

Route::resource('departamentos', DepartamentoController::class);

//historial departamentos
Route::get('/ExportHistorialDptExcel', [historial_departamentoController::class, 'exportarAllHistorialDepartamentos_Excel'])->name('Departamaento.ExportexcelHistotial');
Route::get('/ExportHistorialDptPdf', [historial_departamentoController::class, 'exportarAllHistorialDepartamentos_Pdf'])->name('Departamaento.ExportPdfHistotial');

Route::resource('Historial_Departamentos', historial_departamentoController::class);

Route::get('/tests_kev', [TestsController::class, 'index'])->name('Tests.test');
