<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::all();
        return view('admin.turnos.index', compact('turnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:turnos|max:255',
        ], [
            'nombre.unique' => 'Este turno ya existe.'
        ]);

        Turno::create($request->all());

        return redirect()->route('admin.turnos.index')
            ->with('mensaje', 'Turno creado correctamente')
            ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $turno = Turno::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:255|unique:turnos,nombre,' . $id,
        ], [
            'nombre.unique' => 'Este turno ya existe.'
        ]);

        if ($turno->nombre == $request->nombre) {
            return redirect()->back()
                ->withErrors(['nombre' => 'No hiciste ningún cambio.'])
                ->withInput();
        }

        $turno->nombre = $request->nombre;
        $turno->save();

        return redirect()->route('admin.turnos.index')
            ->with('mensaje', 'Turno actualizado')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        Turno::findOrFail($id)->delete();

        return redirect()->route('admin.turnos.index')
            ->with('mensaje', 'Turno eliminado')
            ->with('icono', 'success');
    }
}