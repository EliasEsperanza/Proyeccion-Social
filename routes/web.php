<?php

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