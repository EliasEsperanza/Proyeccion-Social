<?php

use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\TestsKevControllerController;
use App\Http\Controllers\AsignacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatDocumentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\HorasSocialesController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProyectosDocumentosController;
use App\Http\Controllers\ProyectosEstudiantesController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('login.login');
})->name('login');

Route::get('/hrs', function () {
    return view('estudiantes.actualizar-horas');
});

Route::post('/', [UserController::class, 'login'])->name('login.process');

Route::get('/dashboard/datos-grafico', [ProyectoController::class, 'obtenerDatosGrafico'])->name('dashboard.datosGrafico');
Route::get('/dashboard/estudiantes-proyectos-por-fecha', [ProyectoController::class, 'obtenerEstudiantesYProyectosPorFecha'])->name('dashboard.estudiantesProyectosPorFecha');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth') 
    ->name('dashboard');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/'); 
})->middleware('auth')->name('logout');

Route::get('/registro', [UserController::class, 'allSeccionRegistro'])->name('registro');
Route::post('/registro', [UserController::class, 'registro'])->name('usuarios.registro');


// -----------------rutas de proyectos---------
Route::get('/proyecto-g',[ProyectoController::class, 'index'], function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Administrador', 'Coordinador', 'Tutor'])) {
        return view('proyecto.proyecto-general');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('proyecto-g');
Route::get('/proyecto', function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
        return view('proyecto.publicar-proyecto');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('proyecto');


//Mostrar los departamentos en publicar proyectos
Route::get('/proyecto', [ProyectoController::class, 'retornar_departamentos'])->name('proyecto');

Route::get('/proyecto-disponible',[ProyectoController::class, 'retornar_proyectos'], function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Administrador', 'Coordinador', 'Tutor'])) {
        return view('proyecto.proyect-disponible');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('proyecto-disponible');


// Ruta para la página del gestor de TI
Route::get('/gestor-de-TI', [ProyectoController::class, 'gestor_de_TI'])
    ->name('gestor_de_TI');
// Ruta para la solicitud de proyecto
Route::get('/solicitud-proyecto', [ProyectoController::class, 'solicitud_proyecto'])
    ->name('solicitud_proyecto');

Route::get('/proyecto/{id}/editar',[ProyectoController::class, 'edit'], function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
        return view('proyecto.proyecto-editar');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('proyecto.proyecto-editar');

Route::post('/proyectos/{proyecto}/asignar-estudiantes', [ProyectoController::class, 'asignarEstudiante'])->name('proyectos.asignarEstudiante');
Route::delete('/proyectos/{proyecto}/eliminar-estudiante/{estudiante}', [ProyectoController::class, 'eliminarEstudiante'])->name('proyectos.eliminarEstudiante');
Route::put('/proyectos/{proyecto}/actualizar', [ProyectoController::class, 'actualizar'])->name('proyectos.actualizar');


Route::get('/mensajeria', function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
        return view('mensaje.mensaje');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('mensajeria');

Route::get('/gestion-proyecto', function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Coordinador', 'Administrador'])) {
        return view('gestionProyectos.gestionProyectos');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('gestion-proyecto');

Route::get('/gestion-permiso', function () {
    if (Auth::check() && auth()->user()->hasRole('Administrador')) {
        return view('permisos.gestionpermiso');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('gestion-permiso');

Route::get('/gestion-roles', [RoleController::class, 'index'])->middleware('auth')->name('gestion-roles');


Route::get('/detalle', function () {
    if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
        return view('proyecto.detalle-proyecto');
    }
    return view('dashboard.dashboard');
})->middleware('auth')->name('detalle');


Route::get('/crear', [UserController::class, 'allSeccion'])->name('crear');
Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.editarUsuario');
Route::put('/usuarios/{id}/actualizar', [UserController::class, 'update'])->name('usuarios.actualizar');
Route::get('/usuarios', [UserController::class, 'list'])->name('usuarios');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::delete('/usuarios/eliminar', [UserController::class, 'deleteSelected'])->name('usuarios.eliminar');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.eliminarUsuario');
Route::get('/usuarios/buscar', [UserController::class, 'buscar'])->name('usuarios.buscar');

Route::get('/est', function () {
    return view('estudiantes.dashboard');
});

Route::resource('permissions', PermissionController::class)->except(['show']);

// Rutas de departamentos
Route::get('/ExportDptExcel', [DepartamentoController::class, 'exportarAllDepartamentos_Excel'])->name('Departamento.ExportExcel');
Route::get('/ExportDptPdf', [DepartamentoController::class, 'exportarAllDepartamentos_Pdf'])->name('Departamento.ExportPdf');
Route::resource('departamentos', DepartamentoController::class);

// Rutas de historial departamentos
Route::get('/ExportHistorialDptExcel', [HistorialDepartamentoController::class, 'exportarAllHistorialDepartamentos_Excel'])->name('Departamento.ExportExcelHistorial');
Route::get('/ExportHistorialDptPdf', [HistorialDepartamentoController::class, 'exportarAllHistorialDepartamentos_Pdf'])->name('Departamento.ExportPdfHistorial');
Route::resource('Historial_Departamentos', HistorialDepartamentoController::class);

// Rutas de prueba de Tests_Kev
Route::get('/tests_kev', [TestsKevControllerController::class, 'index'])->name('Tests.test');

// Rutas de layouts y perfil
Route::get('/layouts', function () {
    return view('layouts.gestion-de-roles');
})->name('roles');

Route::get('perfil/{id}', [UserController::class, 'showPerfil'])->name('perfil');

// Rutas del controlador Estudiante
Route::controller(EstudianteController::class)
    ->prefix('estudiantes')
    ->name('estudiantes.')
    ->group(function () {
        Route::get('/', 'index')->name('index');          
        Route::get('/create', 'create')->name('create');          
        Route::post('/', 'store')->name('store'); 

        Route::get('/{id}', 'show')->name('show');        
        Route::put('/{id}', 'update')->name('update');    
        Route::delete('/{id}', 'destroy')->name('destroy'); 
    });

// Rutas del controlador Proyecto
// Route::controller(ProyectoController::class)
//     ->prefix('proyectos')
//     ->name('proyectos.')
//     ->group(function () {
//         Route::get('/', 'index')->name('index');          
//         Route::post('/', 'store')->name('store');         
//         Route::get('/{id}', 'show')->name('show');        
//         Route::put('/{id}', 'update')->name('update');    
//         Route::delete('/{id}', 'destroy')->name('destroy'); 
//     });

    Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');

// Rutas de recuperación y reseteo de contraseña
Route::get('/recuperarpassword', function () {
    return view('auth.recupassword');
})->name('recuperarpassword');

Route::get('/resetearpassword/{idUser}',[UserController::class,'resetearpassword'] );

Route::post('/enviocorreocode', [UserController::class, 'enviocorreocode'])->name('enviocorreocode');

Route::post('/updatepassword/{idUser}', [UserController::class, 'updatepassword'])->name('updatepassword');

// Rutas del controlador Estado
Route::controller(EstadoController::class)->group(function () {
    Route::get('/estados', 'index');            
    Route::post('/estados', 'store');          
    Route::get('/estados/{id}', 'show');        
    Route::put('/estados/{id}', 'update');       
    Route::delete('/estados/{id}', 'destroy');   
});

// Rutas del controlador Documento
Route::controller(DocumentoController::class)->group(function () {
    Route::get('/documentos', 'index');            
    Route::post('/documentos', 'store');            
    Route::get('/documentos/{id}', 'show');        
    Route::put('/documentos/{id}', 'update');       
    Route::delete('/documentos/{id}', 'destroy');   
});

// Rutas del controlador Asignacion
Route::controller(AsignacionController::class)
    ->prefix('asignaciones')
    ->name('asignaciones.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/export/excel', 'exportExcel')->name('export.excel');
        Route::get('/export/pdf', 'exportPDF')->name('export.pdf');
    });

// Rutas del controlador ChatDocumento
Route::controller(ChatDocumentoController::class)
    ->prefix('chat_documentos')
    ->name('chat_documentos.')
    ->group(function () {
        Route::get('/', 'index')->name('index');            
        Route::get('/crear', 'create')->name('create');       
        Route::post('/', 'store')->name('store');            
        Route::get('/{id}/editar', 'edit')->name('edit');   
        Route::put('/{id}', 'update')->name('update');            
        Route::delete('/{id}', 'destroy')->name('destroy');         
        Route::get('/buscar', 'search')->name('search');            
    });

// Rutas del controlador HorasSociales
Route::controller(HorasSocialesController::class)
    ->prefix('horas_sociales')
    ->name('horas_sociales.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/estudiante/{id_estudiante}', 'getHorasByEstudiantes')->name('getHorasByEstudiantes');
    });

// Rutas del controlador Notification
Route::controller(NotificacionController::class)
    ->prefix('notificaciones')
    ->name('notificaciones.')
    ->group(function () {
        Route::get('/usuario/{userId}', 'index')->name('index');        
        Route::get('/create', 'create')->name('create');                  
        Route::post('/', 'store')->name('store');                        
        Route::get('/{id}', 'show')->name('show');                        
        Route::get('/{id}/edit', 'edit')->name('edit');                   
        Route::put('/{id}', 'update')->name('update');                   
        Route::delete('/{id}', 'destroy')->name('destroy');               
    });

// Rutas del controlador ProyectosDocumentos
Route::controller(ProyectosDocumentosController::class)
    ->prefix('proyectos_documentos')
    ->name('proyectos_documentos.')
    ->group(function () {
        Route::get('/', 'index')->name('index');             
        Route::get('/create', 'create')->name('create');      
        Route::post('/', 'store')->name('store');            
        Route::get('/{id}', 'show')->name('show');            
        Route::get('/{id}/edit', 'edit')->name('edit');      
        Route::put('/{id}', 'update')->name('update');        
        Route::delete('/{id}', 'destroy')->name('destroy');  
    });
    //Rutas de controllador de roles 
    Route::get('/layouts/roles', [RoleController::class, 'index'])->name('layouts.roles');
    Route::post('/layouts/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/layouts/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::put('/layouts/roles/{role}', [RoleController::class, 'update'])->name('roles.update');

    Route::get('/perfil_usuario', [UserController::class, 'mostrarPerfil'], function () {
        return view('usuarios.perfilUsuario');
    })->name('perfil_usuario');

    Route::put('/perfil_usuario/{id}', [UserController::class, 'updateusuario'])->name('update_usuario');

    Route::put('/perfil_usuario', [UserController::class, 'updatepassperfil'])->name('update_password');


    //ruta solicitud proyectos de estudiantes
    Route::get('/solicitudproyecto', function () {
        return view('estudiantes.solicitud-proyecto');
    });

    //ruta dashboard de estudiantes
    Route::get('/pry', function () {
        return view('estudiantes.dashboard');
    });

    Route::get('/gestor-de-TI', [ProyectoController::class, 'gestor_de_TI'])->name('gestor_de_TI');
    Route::get('/solicitud-proyecto', [ProyectoController::class, 'solicitud_proyecto'])->name('solicitud_proyecto');

    Route::get('/detallesmio', [ProyectosEstudiantesController::class, 'detallesmio'])->name('detallesmio');
    Route::get('/proyectomio', [ProyectosEstudiantesController::class, 'proyectomio'])->name('proyectomio');

    

?>

