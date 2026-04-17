<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index()
    {
        $niveles = Nivel::all();
        return view('admin.niveles.index', compact('niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:nivels|max:255',
        ]);

        Nivel::create($request->all());

        return redirect()->route('admin.niveles.index')
            ->with('mensaje', 'Nivel creado correctamente')
            ->with('icono', 'success');
    }

    public function edit($id)
    {
        $nivel = Nivel::findOrFail($id);
        return view('admin.niveles.edit', compact('nivel'));
    }

    public function update(Request $request, $id)
    {
        $nivel = \App\Models\Nivel::findOrFail($id);

        // 🔥 VALIDACIÓN
        $request->validate([
            'nombre' => 'required|max:255|unique:nivels,nombre,' . $id,
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'Este nivel ya está registrado.',
        ]);

        // 🚨 VALIDACIÓN EXTRA (LO QUE TÚ QUIERES)
        if ($nivel->nombre == $request->nombre) {
            return redirect()->back()
                ->withErrors(['nombre' => 'No hiciste ningún cambio.'])
                ->withInput();
        }

        // ✅ ACTUALIZAR
        $nivel->nombre = $request->nombre;
        $nivel->save();

        return redirect()->route('admin.niveles.index')
            ->with('mensaje', 'Nivel actualizado correctamente.')
            ->with('icono', 'success');
    }
    
    public function destroy($id)
    {
        Nivel::findOrFail($id)->delete();

        return redirect()->route('admin.niveles.index')
            ->with('mensaje', 'Nivel eliminado')
            ->with('icono', 'success');
    }
    
}