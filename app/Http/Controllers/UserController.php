<?php
namespace App\Http\Controllers;

use App\Mail\mailrecuperarpassword;
use App\Models\CodigosRecuperacion;
use App\Models\User;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $role = $request->input('role'); 
    
        // Subconsulta para cada tipo de usuario, incluyendo una columna de rol estática
        $estudiantes = User::estudiantesPorSeccion()
            ->select('users.*', 'secciones.nombre_seccion as seccion', \DB::raw("'estudiante' as user_role"))
            ->toBase();
    
        $tutores = User::tutoresPorSeccion()
            ->select('users.*', 'secciones.nombre_seccion as seccion', \DB::raw("'tutor' as user_role"))
            ->toBase();
    
        $coordinadores = User::coordinadoresPorSeccion()
            ->select('users.*', 'secciones.nombre_seccion as seccion', \DB::raw("'coordinador' as user_role"))
            ->toBase();
    
        $administradores = User::administradoresPorSeccion()
            ->select('users.*', \DB::raw("NULL as seccion"), \DB::raw("'administrador' as user_role"))
            ->toBase();
    
        // Unir las subconsultas
        $query = User::query()->fromSub(
            $administradores
                ->unionAll($coordinadores)
                ->unionAll($tutores)
                ->unionAll($estudiantes),
            'users_ordenados'
        );
    
        // Filtro de búsqueda
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('seccion', 'LIKE', "%{$search}%");
            });
        }
    
        // Filtro por rol, ignorando la columna `seccion` para administradores
        if ($role) {
            $query->where('user_role', '=', $role);
    
            // Solo aplicamos el filtro de sección si el rol no es 'administrador'
            if ($role !== 'administrador') {
                $query->whereNotNull('seccion');
            }
        }
    
        // Paginación
        $users = $query->paginate($perPage);
    
        return view('usuarios.listaUsuario', compact('users'));
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');
        
        // Subconsultas similares a tu método list
        $estudiantes = User::estudiantesPorSeccion()
            ->select('users.*', 'secciones.nombre_seccion as seccion', \DB::raw("'estudiante' as user_role"))
            ->toBase();
    
        $tutores = User::tutoresPorSeccion()
            ->select('users.*', 'secciones.nombre_seccion as seccion', \DB::raw("'tutor' as user_role"))
            ->toBase();
    
        $coordinadores = User::coordinadoresPorSeccion()
            ->select('users.*', 'secciones.nombre_seccion as seccion', \DB::raw("'coordinador' as user_role"))
            ->toBase();
    
        $administradores = User::administradoresPorSeccion()
            ->select('users.*', \DB::raw("NULL as seccion"), \DB::raw("'administrador' as user_role"))
            ->toBase();
    
        // Unir las subconsultas
        $users = User::query()
            ->fromSub(
                $administradores
                    ->unionAll($coordinadores)
                    ->unionAll($tutores)
                    ->unionAll($estudiantes),
                'users_ordenados'
            )
            ->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('seccion', 'LIKE', "%{$search}%");
            })
            ->get()
            ->map(function($user) {
                return [
                    'id_usuario' => $user->id_usuario,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->user_role,
                    'seccion' => $user->seccion ?? 'Sin sección',
                ];
            });
    
        return response()->json($users);
    }
    
    //mostrar usuario especifico
    public function showPerfil($id)
    {
        $usuario = User::findOrFail($id);
    
        return view('perfil.perfilUsuario', compact('usuario'));
    }
    public function allSeccion()
    {
        $secciones=Seccion::all();
        return view("usuarios.crearUsuario",compact("secciones"));
    }
    public function allSeccionRegistro()
    {
        $secciones=Seccion::all();
        return view("registro.registro",compact("secciones"));
    }

    public function registro(Request $request)
    {
        try {
            // Validación de los datos
            $request->validate([
                'nombre' => 'required|string|max:255',
                'correo' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'id_seccion' => 'nullable|exists:secciones,id_seccion',
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'El correo debe ser válido.',
                'correo.unique' => 'Este correo ya está registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'id_seccion.exists' => 'La sección seleccionada no existe.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => bcrypt($request->password),
        ]);
    
        $user->assignRole('estudiante');
    
        if ($request->filled('id_seccion')) {
            \DB::table('estudiantes')->insert([
                'id_usuario' => $user->id_usuario, 
                'id_seccion' => $request->id_seccion,
                'porcentaje_completado' => 0, 
                'horas_sociales_completadas' => 0,
            ]);
        }
    
        return redirect()->route('login')->with('success', 'Usuario creado exitosamente');
    }

    public function store(Request $request)
    {
        try {
            // Validación de los datos
            $request->validate([
                'nombre' => 'required|string|max:255',
                'correo' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'rol' => 'required|string|exists:roles,name',
                'id_seccion' => 'nullable|exists:secciones,id_seccion',
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'El correo debe ser válido.',
                'correo.unique' => 'Este correo ya está registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'rol.required' => 'El rol es obligatorio.',
                'rol.exists' => 'El rol seleccionado no existe.',
                'id_seccion.exists' => 'La sección seleccionada no existe.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => bcrypt($request->password),
        ]);
    
        $user->assignRole($request->rol);
    
        if ($request->filled('id_seccion')) {
            $idSeccion = $request->id_seccion;
    
            if ($request->rol === 'estudiante') {
                \DB::table('estudiantes')->insert([
                    'id_usuario' => $user->id_usuario,
                    'id_seccion' => $idSeccion,
                    'porcentaje_completado' => 0, 
                    'horas_sociales_completadas' => 0,
                ]);
            }
            elseif ($request->rol === 'tutor') {
                \DB::table('seccion_tutor')->insert([
                    'id_tutor' => $user->id_usuario,
                    'id_seccion' => $idSeccion
                ]);
            }
            elseif ($request->rol === 'coordinador') {
                \DB::table('secciones')
                    ->where('id_seccion', $idSeccion)
                    ->update(['id_coordinador' => $user->id]);
            }
        }
    
        return redirect()->route('usuarios')->with('success', 'Usuario creado exitosamente');
    }

    public function deleteSelected(Request $request)
    {
        // Validar que se haya seleccionado al menos un usuario
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id_usuario'
        ]);

        // Eliminar los usuarios seleccionados
        User::whereIn('id_usuario', $request->input('users'))->delete();

        return redirect()->route('usuarios')->with('success', 'Usuarios eliminados exitosamente.');
    }
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios')->with('success', 'Usuario eliminado correctamente.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $secciones=Seccion::all();
        return view('usuarios.editarUsuario', compact('usuario', 'secciones'));
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'correo' => 'required|email|unique:users,email,' . $id . ',id_usuario',
                'rol' => 'required|string|exists:roles,name',
                'id_seccion' => 'nullable|exists:secciones,id_seccion',
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'El correo debe ser válido.',
                'correo.unique' => 'Este correo ya está registrado.',
                'rol.required' => 'El rol es obligatorio.',
                'rol.exists' => 'El rol seleccionado no existe.',
                'id_seccion.exists' => 'La sección seleccionada no existe.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    
        $usuario = User::findOrFail($id);
        $usuario->name = $request->nombre;
        $usuario->email = $request->correo;
        $usuario->save();
    
        $usuario->syncRoles($request->rol);
    
        if ($request->filled('id_seccion')) {
            $idSeccion = $request->id_seccion;
    
            if ($request->rol === 'estudiante') {

                \DB::table('estudiantes')
                    ->updateOrInsert(
                        ['id_usuario' => $usuario->id_usuario], 
                        [
                            'id_seccion' => $idSeccion, 
                            'porcentaje_completado' => 0,
                            'horas_sociales_completadas' => 0
                        ]
                    );
            } elseif ($request->rol === 'tutor') {

                \DB::table('seccion_tutor')
                    ->updateOrInsert(
                        ['id_tutor' => $usuario->id_usuario],
                        ['id_seccion' => $idSeccion]
                    );
            } elseif ($request->rol === 'coordinador') {
                \DB::table('secciones')
                    ->where('id_seccion', $idSeccion)
                    ->update(['id_coordinador' => $usuario->id_usuario]);
            }
        }
    
        return redirect()->route('usuarios')->with('success', 'Usuario y sección actualizados exitosamente');
    }

    public function enviocorreocode(Request $request){
        try {
            $email = $request->correo;
            $user = User::where('email', $email)->first();
            //dd($user);
            $codigo = substr(md5(uniqid()), 0, 6);
            $codigorecuperacion = new CodigosRecuperacion();
            $codigorecuperacion->codigo = $codigo;
            CodigosRecuperacion::create([
                'codigo' => $codigo
            ]);
            $urlpassword = url('/resetearpassword/'.$user->id_usuario);
            Mail::to($email)->send(new mailrecuperarpassword($user, $codigo, $urlpassword));
            session()->flash('success', 'Se ha enviado un correo con el código de recuperación');
            return view('auth.recupassword');
        }catch (\Exception $e) {
            session()->flash('error', 'El correo no existe');
            return view('auth.recupassword');
        }
    }
    public function resetearpassword($idUser){
        return view('auth.resetpassword', compact('idUser'));
    }
    public function updatepassword(Request $request, $idUser){
        $user = User::find($idUser);
        $codigo = CodigosRecuperacion::where('codigo', $request->codigo_verificacion)->first();
        if(!$codigo){
            session()->flash('error', 'El código de verificación es incorrecto');
            return view('auth.resetpassword', compact('idUser'));
        }
        $user->password = bcrypt($request->nueva_contrasena);
        $user->save();
        CodigosRecuperacion::where('codigo', $request->codigo_verificacion)->delete();
        return redirect('/');
    }

    public function updatepassperfil(Request $request)
    {
        $request->validate([
            'contrasena_actual' => 'required',
            'nueva_contrasena' => [
                'required',
                'string',
                'min:8', // mínimo 8 caracteres
                'confirmed', // requiere nueva_contrasena_confirmation
                'different:contrasena_actual', // debe ser diferente a la actual
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/' // debe contener mayúsculas, minúsculas, números y caracteres especiales
            ],
            'nueva_contrasena_confirmation' => 'required'
        ], [
            'contrasena_actual.required' => 'La contraseña actual es requerida',
            'nueva_contrasena.required' => 'La nueva contraseña es requerida',
            'nueva_contrasena.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'nueva_contrasena.confirmed' => 'Las contraseñas no coinciden',
            'nueva_contrasena.different' => 'La nueva contraseña debe ser diferente a la actual',
            'nueva_contrasena.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial',
            'nueva_contrasena_confirmation.required' => 'Debe confirmar la nueva contraseña'
        ]);
    
        $user = User::find(Auth::user()->id_usuario);
            if (!Hash::check($request->contrasena_actual, $user->password)) {
            return back()->withErrors([
                'contrasena_actual' => 'La contraseña actual es incorrecta.',
            ])->withInput();
        }
        try {
            $user->password = Hash::make($request->nueva_contrasena);
            $user->save();
            return redirect('/perfil_usuario')->with('success', 'Contraseña actualizada correctamente');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Ocurrió un error al actualizar la contraseña. Por favor, intente nuevamente.'
            ]);
        }
    }

    public function mostrarPerfil()
    {
        $usuario = Auth::user(); 
        return view('usuarios.perfilUsuario', compact('usuario'));
    }
    public function updateusuario(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:28',
                    'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
                ],
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no puede tener más de 22 caracteres.',
                'nombre.regex' => 'El nombre solo puede contener letras.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    
        $usuario = User::findOrFail($id);
        $usuario->name = $request->nombre;
        $usuario->save();
    
        return redirect()->route('perfil_usuario')->with('success', 'Perfil actualizado correctamente');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'contrasena');
    
        if (Auth::attempt(['email' => $credentials['correo'], 'password' => $credentials['contrasena']])) {
            $request->session()->regenerate();
            
            // Obtener el usuario autenticado
            $user = Auth::user();
            
            // Verificar si el usuario tiene el rol de Estudiante
            if ($user->hasRole('Estudiante')) {
                return redirect()->route('estudiantes.dashboard');
            }
            
            // Redireccionamiento por defecto para otros roles
            return redirect()->intended('/dashboard');
        }
    
        return redirect()->route('login')->withErrors([
            'error' => 'Usuario o contraseña inválidos.',
        ]);
    }

    public function totalTutores()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'Tutor');
        })->count();
    }

    public function getUsers()
    {
        // Obtener todos los usuarios de la base de datos
        $users = User::all();

        // Retornar los usuarios en formato JSON
        return response()->json($users);
    }

    public function show()
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador'])) {
            return view('mensaje.mensaje');
        }
        return view('dashboard.dashboard');
    }
}