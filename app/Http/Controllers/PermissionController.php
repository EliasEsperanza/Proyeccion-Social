<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all(); // muestra todos los permisos
        return view('permisos.gestionpermiso', compact('permissions')); // Pasa la variable a la vista
    }
    
//###########################################################################################
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permiso creado exitosamente.');
    }

    public function edit(Permission $permission)
    {
        return response()->json($permission); // Para editar
    }
    //###########################################################################################

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permiso actualizado exitosamente.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permiso eliminado correctamente.');
    }
}