<?php

use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\TestsKevControllerController;
use App\Http\Controllers\AsignacionController;
use App\Http\Middleware\LogedCheck;
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
use App\Models\Estado;
use App\Models\Proyecto;
use App\Http\Middleware\RolCheck;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SolicitudesController;
use app\Http\Controllers\SolicitudProyectoController;
use App\Http\Controllers\SoliciudHorasController;

//LOGIN/WELCOME-------------------------------------------------------------------------------------------------------------------------------------
Route::get('/', function () {
    return view('Bienvenida');
})->name('Bienvenida');

Route::get('/login', function () {
    return view('login.login');
})->name('login');
Route::get('/malisioso', function () {
    return view('Malisioso');
})->name('Malisioso');

Route::post('/log-process', [UserController::class, 'login'])->name('login.process');
Route::get('/registro', [UserController::class, 'allSeccionRegistro'])->name('registro');

Route::get('/proyectos/{id}', [ProyectoController::class, 'obtenerDetallesProyectoFU']);


//LOGED CHECK-------------------------------------------------------------------------------------------------------------------------------------
Route::middleware([LogedCheck::class])->group(function () {

    Route::get('/curret-user', [AuthController::class, 'Identificador']);

    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->middleware('auth')->name('logout');

    Route::get('/mensajeria', [UserController::class, 'show'])
        ->middleware('auth')
        ->name('mensajeria');

    Route::get('/perfil_usuario', [UserController::class, 'mostrarPerfil'], function () {
        return view('usuarios.perfilUsuario');
    })->name('perfil_usuario');

    Route::put('/perfil_usuario/{id}', [UserController::class, 'updateusuario'])->name('update_usuario');

    Route::put('/perfil_usuario', [UserController::class, 'updatepassperfil'])->name('update_password');
    //Route::get('/hrs', [EstudianteController::class, 'actualizarHorasView'])->name('estudiante.actualizarHorasView');


    Route::middleware(['App\Http\Middleware\RolCheck:Estudiante'])->group(function () {
        // === Rutas de lectura (GET) ===
        // Visualización de proyectos
        Route::get('/progreso-global/{id}', [EstudianteController::class, 'ProgresoGlobal'])->name('estudiantes.ProgresoGlobal');

        Route::post('/Avance-horas', [EstudianteController::class, 'Solicitud_avance_horas'])->name('estudiante.Avance_horas');
        Route::get('/actualizar-horas', [EstudianteController::class, 'actualizarHorasView'])->name('estudiante.actualizarHorasView');
        Route::get('/mi-proyecto', [ProyectosEstudiantesController::class, 'Mi_proyecto'])->name('proyectomio');
        Route::get('/dashboard/estudiantes', [ProyectoController::class, 'obtenerProyectosDashboard'])->name('estudiantes.dashboard');
        Route::get('/proyectos/{id}/ver', [ProyectoController::class, 'mostrarProyecto'])->name('proyecto.ver');
        Route::get('/detalles-mi-proyecto', [ProyectosEstudiantesController::class, 'Detalles_proyecto'])->name('detallesmio');

        // Solicitudes y procesos
        Route::get('/solicitud-proyecto', [ProyectoController::class, 'solicitud_proyecto'])->name('solicitud_proyecto');
        Route::get('/solicitud-proyecto', [ProyectosEstudiantesController::class, 'Solicitud_Proyecto_Student'])->name('solicitud-proyecto');
        Route::get('/solicitud-proyecto/create', [ProyectoController::class, 'create'])->name('solicitud_proyecto.create');
        Route::get('/procesos', [ProyectosEstudiantesController::class, 'Procesos'])->name('vista_procesos_horas');

        // Documentos y descargas
        Route::get('/documentos-horas-sociales', function () {
            return view('estudiantes.documentos-sociales');
        })->name('documentos_horas_sociales');
        Route::get('/docs', [ProyectosEstudiantesController::class, 'docs'])->name('docs_tramites');
        Route::get('/descargar/{filename}', function ($filename) {
            $filePath = 'documentos/' . $filename;
            if (Storage::disk('public')->exists($filePath)) {
                return response()->download(storage_path('app/public/' . $filePath));
            } else {
                abort(404, 'Archivo no encontrado.');
            }
        })->name('descargar');

        Route::post('/store_solicitud', [SolicitudProyectoController::class, 'store_solicitud'])->name('proyectos.store_solicitud');
        Route::post('/store_solicitud_alumno', [SolicitudProyectoController::class, 'store_solicitud_alumno'])->name('store_solicitud_alumno');

        // === Notas importantes ===
        // Hay rutas duplicadas para `/solicitud-proyecto`. Asegúrate de eliminar los duplicados o combinar la lógica en un único controlador o método para evitar conflictos.
    });


    Route::middleware(['App\Http\Middleware\RolCheck:Administrador'])->group(function () {
        // Rutas solo accesibles por Administrador

        Route::get('/dashboard/estudiantes-proyectos-por-fecha', [ProyectoController::class, 'obtenerEstudiantesYProyectosPorFecha'])->name('dashboard.estudiantesProyectosPorFecha');
        Route::post('/proyectos/{proyecto}/gestionActualizar', [AsignacionController::class, 'gestionActualizar'])->name('proyectos.gestionActualizar');

        Route::get('/proyectos-solicitudes', [SolicitudProyectoController::class, 'solicitudes_coordinador'])->name('solicitudes_coordinador');
        Route::get('/dashboard/datos-grafico', [ProyectoController::class, 'obtenerDatosGrafico'])->name('dashboard.datosGrafico');
        Route::post('/registro', [UserController::class, 'registro'])->name('usuarios.registro');

        Route::get('/dashboard/admin', [DashboardController::class, 'index'])
            ->middleware('auth')
            ->name('dashboard');
        Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');


        Route::get('/verDetallesSolicitud/{id_proyecto}', [ProyectoController::class, 'detallesSolicitud'])->name('detallesSolicitud');
        Route::post('/proyecto/aceptar/{id_proyecto}', [SolicitudProyectoController::class, 'aceptarSolicitud'])->name('proyectos.aceptar');
        Route::post('/proyecto/rechazar/{id_proyecto}', [SolicitudProyectoController::class, 'rechazarSolicitud'])->name('proyectos.rechazar');
        // -----------------rutas de proyectos---------
        Route::get('/proyectos-en-curso', [ProyectoController::class, 'index'], function () {
            if (Auth::check() && auth()->user()->hasAnyRole(['Administrador', 'Coordinador', 'Tutor'])) {
                return view('proyecto.proyecto-en-curso');
            }
            return view('dashboard.dashboard');
        })->middleware('auth')->name('proyecto-g');

        Route::get('/proyecto', function () {
            if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
                return view('proyecto.publicar-proyecto');
            }
            return view('dashboard.dashboard');
        })->middleware('auth')->name('proyecto');

        Route::delete('/proyecto/{id}', [ProyectoController::class, 'destroy'])->name('proyecto.eliminarProyecto');
        Route::post('/proyectos/generar', [ProyectoController::class, 'generar'])->name('proyectos.generar');

        Route::get('/asignar-proyecto', [ProyectoController::class, 'edit_gestion_proyecto'], function () {
            if (Auth::check() && auth()->user()->hasAnyRole(['Coordinador', 'Administrador'])) {
                $estados = Estado::orderBy('nombre_estado', 'asc')->get();

                return view('gestionProyectos.gestionProyectos', compact('estados'));
            }
            return view('dashboard.dashboard');
        })->middleware('auth')->name('gestion-proyecto');


        //editar
        Route::get('/proyecto/{id}/editar_proyecto', [ProyectoController::class, 'edit_proyecto'], function () {
            if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
                return view('proyecto.editar-proyecto');
            }
            return view('dashboard.dashboard');
        })->middleware('auth')->name('proyecto.editar-proyecto');

        //Update proyecto 
        Route::put('/proyectos/{id}/update_proyecto', [ProyectoController::class, 'update_proyecto'])->name('proyectos.proyectos_update');

        //Mostrar los detalle de los proyectos 
        Route::get('/proyecto/{id}/detalle', [ProyectoController::class, 'obtenerDetalleProyecto'])->name('obtener-detalle');

        Route::get('/proyecto/{id}/descargar-pdf', [ProyectoController::class, 'descargarPDF'])->name('proyecto.descargar-pdf');

        //Mostrar los departamentos en publicar proyectos
        Route::get('/proyecto', [ProyectoController::class, 'retornar_departamentos'])->name('proyecto');

        Route::get('/proyecto-disponible', [ProyectoController::class, 'retornar_proyectos'], function () {
            if (Auth::check() && auth()->user()->hasAnyRole(['Administrador', 'Coordinador', 'Tutor'])) {
                return view('proyecto.proyect-disponible');
            }
            return view('dashboard.dashboard');
        })->middleware('auth')->name('proyecto-disponible');

        // Ruta para la solicitud de proyecto
        Route::get('/proyecto-disponibles-list', [ProyectoController::class, 'proyecto_disponible_list'])->name('proyecto_disponible_list');

        Route::get('/proyecto/{id}/editar', [ProyectoController::class, 'edit'], function () {
            if (Auth::check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
                return view('proyecto.proyecto-editar');
            }
            return view('dashboard.dashboard');
        })->middleware('auth')->name('proyecto.proyecto-editar');

        Route::post('/proyectos/{proyecto}/asignar-estudiantes', [AsignacionController::class, 'asignarEstudiante'])->name('proyectos.asignarEstudiante');
        Route::post('/proyectos/{proyecto}/asignar-estudiantes-gestion', [AsignacionController::class, 'asignarEstudianteGestion'])->name('proyectos.asignarEstudianteGestion');
        Route::delete('/proyectos/{proyecto}/eliminar-estudiante/{estudiante}', [AsignacionController::class, 'eliminarEstudiante'])->name('proyectos.eliminarEstudiante');
        Route::put('/proyectos/{proyecto}/actualizar', [ProyectoController::class, 'actualizar'])->name('proyectos.actualizar');
        Route::post('/proyectos/asignar', [ProyectoController::class, 'asignarProyecto'])->name('proyectos.asignar');

        Route::get('/proyectos/{proyecto}/estudiantes', function ($proyectoId) {
            $proyecto = Proyecto::with('estudiantes.usuario')->findOrFail($proyectoId);
            return response()->json([
                'estudiantes' => $proyecto->estudiantes->map(function ($estudiante) {
                    return [
                        'id_estudiante' => $estudiante->id_estudiante,
                        'usuario' => ['name' => $estudiante->usuario->name],
                    ];
                }),
                'csrfToken' => csrf_token(),
            ]);
        });



        Route::get('/api/users', [UserController::class, 'getUsers']);

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

        Route::get('/usuarios2', [UserController::class, 'getUsers'])->name('usuarios.getUsers');
        Route::get('/crear', [UserController::class, 'allSeccion'])->name('crear');
        Route::get('/usuarios/editar/{id}', [UserController::class, 'edit'])->name('usuarios.editarUsuario');
        Route::put('/usuarios/{id}/actualizar', [UserController::class, 'update'])->name('usuarios.actualizar');
        Route::get('/usuarios', [UserController::class, 'list'])->name('usuarios');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::delete('/usuarios/eliminar', [UserController::class, 'deleteSelected'])->name('usuarios.eliminar');
        Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'destroy'])->name('usuarios.eliminarUsuario');
        Route::get('/usuarios/buscar', [UserController::class, 'buscar'])->name('usuarios.buscar');

        Route::get('/est', function () {
            return view('estudiantes.dashboard');
        });

        Route::resource('permissions', PermissionController::class)->except(['show']);

        // Rutas de departamentos
        Route::get('/ExportDptExcel', [DepartamentoController::class, 'exportarAllDepartamentos_Excel'])->name('Departamento.ExportExcel');
        Route::get('/ExportDptPdf', [DepartamentoController::class, 'exportarAllDepartamentos_Pdf'])->name('Departamento.ExportPdf');
        Route::resource('departamentos', DepartamentoController::class);

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
        Route::get('/obtenerNombreEstudiante/{id}', [EstudianteController::class, 'obtenerNombreEstudiante'])->name('obtenerNombreEstudiante');

        Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');




        // Rutas de recuperación y reseteo de contraseña
        Route::get('/recuperarpassword', function () {
            return view('auth.recupassword');
        })->name('recuperarpassword');

        Route::get('/resetearpassword/{idUser}', [UserController::class, 'resetearpassword']);

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

        //ruta solicitud proyectos de estudiantes
        Route::get('/solicitudproyecto', function () {
            return view('estudiantes.solicitud-proyecto');
        });

        Route::get('/gestor-de-TI', [ProyectoController::class, 'gestor_de_TI'])->name('gestor_de_TI');
        Route::get('/obtener-tutores-por-seccion/{id}', [ProyectoController::class, 'GetTutoresPorSeccion']);

        //solicitudes de avance de horas
        Route::get('/proyecto/{id}/solicitudes/{solicitud}', [SoliciudHorasController::class, 'mostrarSolicitud'])->name('RevisionSolicitud');
        Route::get('/proyecto/{id}/solicitudes', [SoliciudHorasController::class, 'solicitudes_avance_horas'])->name('solicitudes_avance_horas');
        route::post('/proyecto/{id}/solicitudes/{solicitud}/aprobar', [SoliciudHorasController::class, 'aprobarSolicitud'])->name('aprobarSolicitud');
        route::post('/proyecto/{id}/solicitudes/{solicitud}/denegar', [SoliciudHorasController::class, 'denegarSolicitud'])->name('denegarSolicitud');

        Route::get('/usuarios3', [UserController::class, 'getUsersWithSeccion'])->name('usuarios.getUsersWithSeccion');
    });

    Route::middleware(['App\Http\Middleware\RolCheck:Coordinador'])->group(function () {
        // Rutas solo accesibles por Coordinador

    });

    Route::middleware(['App\Http\Middleware\RolCheck:Tutor'])->group(function () {
        // Rutas solo accesibles por Tutor

    });

    ///////////////////////////////////////////////////UTILIDADES//////////////////////////////////////////////////

    Route::get('/secciones-disponibles', [EstudianteController::class, 'seccionesDisponibles'])->name('secciones.disponibles');
    Route::get('/estudiantes-por-seccion/{idSeccion}', [EstudianteController::class, 'estudiantesPorSeccion'])->name('estudiantes.porSeccion');
    Route::get('/estudiantes-por-seccion-filtro-sin-proyecto/{idSeccion}', [EstudianteController::class, 'estudiantesPorSeccion_FIltroSinProyecto'])->name('estudiantes.porSeccionFiltroSinProyecto');
    Route::get('/proyectos-disponibles', [ProyectoController::class, 'proyectosDisponibles'])->name('proyectos.disponibles');
    Route::get('/proyectos-por-seccion/{id}', [ProyectoController::class, 'proyectosDisponiblesPorSeccion'])->name('proyectos.porSeccion');


    /////////////////////////////////////////////////////////////////////////////////////////////////////


});
