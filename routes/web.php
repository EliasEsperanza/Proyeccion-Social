<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.login');
});

Route::get('/proyecto', function () {
    return view('permisos.gestionpermiso');
})
->name('proyecto');


Route::get('/registro', function () {
    return view('registro.registro');
});

