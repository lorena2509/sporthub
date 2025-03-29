<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CanchaController extends Controller
{
    public function index()
    {
        $canchas = Cancha::all();
        return view('admin.index', compact('canchas'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'capacidad' => 'required|integer',
            'imagen' => 'nu llable|image|max:2048',
        ]);

                    $cancha = new Cancha();
            $cancha->nombre = $request->nombre;
            $cancha->ubicacion = $request->ubicacion;
            $cancha->capacidad = $request->capacidad ?? 0; // Si no se recibe, poner 0

            if ($request->hasFile('imagen')) {
                $cancha->imagen = $request->file('imagen')->store('images', 'public');
            }

            $cancha->save();

        if ($request->hasFile('imagen')) {
            $cancha->imagen = $request->file('imagen')->store('images', 'public');
        }
        $cancha->save();

        return redirect()->route('admin.canchas.index')->with('success', 'Cancha creada exitosamente.');
    }

    public function edit($id)
    {
        $cancha = Cancha::findOrFail($id);
        return view('admin.edit', compact('cancha'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'capacidad' => 'required|integer',
            'imagen' => 'nullable|image|max:2048',
        ]);
    
        $cancha = Cancha::findOrFail($id);
    
        // Forzamos la capacidad
        $cancha->capacidad = (int) $request->capacidad;
    
        // Si se sube nueva imagen, se elimina la anterior
        if ($request->hasFile('imagen')) {
            if ($cancha->imagen && Storage::disk('public')->exists($cancha->imagen)) {
                Storage::disk('public')->delete($cancha->imagen);
            }
            $cancha->imagen = $request->file('imagen')->store('images', 'public');
        }
    
        // Guardar los cambios
        $cancha->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'capacidad' => $cancha->capacidad, // Forzando capacidad
            'imagen' => $cancha->imagen, // Mantiene la imagen actual si no se cambia
        ]);
    
        return redirect()->route('admin.canchas.index')->with('success', 'Cancha actualizada exitosamente.');
    }
    

    public function destroy($id)
    {
        $cancha = Cancha::findOrFail($id);

        if ($cancha->imagen) {
            Storage::disk('public')->delete($cancha->imagen);
        }

        $cancha->delete();

        return redirect()->route('admin.canchas.index')->with('success', 'Cancha eliminada exitosamente.');
    }
}
