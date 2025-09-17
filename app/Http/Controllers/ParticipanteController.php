<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participantes = Participante::latest()->paginate(10);
        
        return view('participantes.index', compact('participantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('participantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $licenciasValidas = array_keys(Participante::getLicenciasOptions());
        
        $request->validate([
            'rut' => 'required|string|unique:participantes,rut',
            'dv' => 'required|string|max:1',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'licencia_conducir' => 'nullable|in:' . implode(',', $licenciasValidas),
        ]);

        Participante::create($request->all());

        return redirect()->route('participantes.index')
            ->with('success', 'Participante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Participante $participante)
    {
        return view('participantes.show', compact('participante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participante $participante)
    {
        return view('participantes.edit', compact('participante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participante $participante)
    {
        $licenciasValidas = array_keys(Participante::getLicenciasOptions());
        
        $request->validate([
            'rut' => 'required|string|unique:participantes,rut,' . $participante->id,
            'dv' => 'required|string|max:1',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'licencia_conducir' => 'nullable|in:' . implode(',', $licenciasValidas),
        ]);

        $participante->update($request->all());

        return redirect()->route('participantes.index')
            ->with('success', 'Participante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participante $participante)
    {
        $participante->delete();

        return redirect()->route('participantes.index')
            ->with('success', 'Participante eliminado exitosamente.');
    }
}
