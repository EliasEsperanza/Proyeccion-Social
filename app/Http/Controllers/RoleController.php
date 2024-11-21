<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['Administrador', 'Coordinador'])) {
            return redirect()->route('dashboard'); 
        }
    
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
    
        return view('layouts.gestion-de-roles', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        // Crear el rol
        $role = Role::create(['name' => $request->name]);

        // Asignar permisos al rol
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('layouts.roles')->with('success', 'Rol creado exitosamente.');
    }

    public function update(Request $request, Role $role)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        // Actualizar el nombre del rol
        $role->update(['name' => $request->name]);

        // Sincronizar permisos
        $role->syncPermissions($request->permissions);

        return redirect()->route('layouts.roles')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        // Eliminar el rol
        $role->delete();
        return redirect()->route('layouts.roles')->with('success', 'Rol eliminado correctamente.');
    }
}
