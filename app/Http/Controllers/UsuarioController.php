<?php

namespace App\Http\Controllers;
use App\Models\Usuario;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //mostrar todos los usuarios
    public function index(){
        $usuario= Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

//mostrar formulario para crear un nuevo user
    public function create(){
        return view('usuario.create');
    }

//guardar un usuario en la BD
    public function store(Request $request){
        $validatedData=$request->validate([
            'nombre'=>'required|string|max:255',
            'correo'=>'required|email|unique:usuarios,correo',
            'rol'=>'required|string',
            'password'=>'required|string',
        ]);
        $usuario =Usuario::create($validatedData);
        return redirect()->route('usuarios.index')->with('succes','Usuario creado correctamente');
    }

    //mostrar un usuario en especifico
    public function show($id){
        $usuario =Usuario::findOrFail($id);
        return view('usuario.show', compact('usuario'));
    }

    //mostrar form para editar un user
    public function  edit($id){
        $usuario= Usuario::findOrFail($id);
        return view('usuario.edit', compact('usuario'));
    }

    //actualizar usuario en la BD
    public function update(Request $request, $id){
        $validatedData=$request->validate([
            'nombre'=>'required|string|max:255',
            'correo'=>'required|email|unique:usuarios,correo',
            'rol'=>'required|string',
            'password'=>'required|string',
        ]);
        $usuario = Usuario::findOrFail($id);
        $usuario->update($validatedData);
        return redirect()->route('usuario.index')->with('Excelente','usuario actualizado con exito');
    }

    //eliminar usuario d ela BD
    public function delete($id){
        $usuario=Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('usuario.index')->with('Hecho','usuario eliminado con exito');
    }


}
