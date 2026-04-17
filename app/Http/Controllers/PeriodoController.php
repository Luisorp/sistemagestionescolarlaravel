<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodoController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::with('periodos')->orderBy('nombre', 'asc')->get();
        return view('admin.periodos.index', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gestion_id' => 'required|exists:gestions,id',
            'nombre' => [
                'required',
                'max:255',
                Rule::unique('periodos')->where(function ($query) use ($request) {
                    return $query->where('gestion_id', $request->gestion_id);
                }),
            ],
        ], [
            'gestion_id.required' => 'Debe seleccionar una gestión.',
            'nombre.required' => 'El nombre del periodo es obligatorio.',
            'nombre.unique' => 'Este periodo ya está registrado en esta gestión.',
        ]);

        Periodo::create([
            'gestion_id' => $request->gestion_id,
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.periodos.index')
            ->with('mensaje', 'Periodo creado correctamente.')
            ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $periodo = Periodo::findOrFail($id);

        $request->validate([
            'gestion_id' => 'required|exists:gestions,id',
            'nombre' => [
                'required',
                'max:255',
                Rule::unique('periodos')
                    ->where(function ($query) use ($request) {
                        return $query->where('gestion_id', $request->gestion_id);
                    })
                    ->ignore($periodo->id),
            ],
        ], [
            'gestion_id.required' => 'Debe seleccionar una gestión.',
            'nombre.required' => 'El nombre del periodo es obligatorio.',
            'nombre.unique' => 'Este periodo ya está registrado en esta gestión.',
        ]);

        $periodo->gestion_id = $request->gestion_id;
        $periodo->nombre = $request->nombre;
        $periodo->save();

        return redirect()->route('admin.periodos.index')
            ->with('mensaje', 'Periodo actualizado correctamente.')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $periodo = Periodo::findOrFail($id);
        $periodo->delete();

        return redirect()->route('admin.periodos.index')
            ->with('mensaje', 'Periodo eliminado correctamente.')
            ->with('icono', 'success');
    }
}