<?php

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

Route::get('/usuarios', function () {
    return view('usuarios.listaUsuario');
})->name('usuarios');