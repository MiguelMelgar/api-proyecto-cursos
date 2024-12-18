<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // Obtener todos los comentarios
    public function index()
    {
        return Comentario::with('user')->get(); // Incluye los datos del usuario relacionado
    }

    // Crear un nuevo comentario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'comentario' => 'required|string',
            'valoracion' => 'required|integer|between:1,5',
            'user_id' => 'required|exists:users,id',
        ]);

        $comentario = Comentario::create($validatedData);

        return response()->json($comentario, 201);
    }

    // Mostrar un comentario específico
    public function show($id)
    {
        $comentario = Comentario::with('user')->findOrFail($id);
        return response()->json($comentario);
    }

    // Actualizar un comentario
    public function update(Request $request, $id)
    {
        $comentario = Comentario::findOrFail($id);

        $validatedData = $request->validate([
            'comentario' => 'string',
            'valoracion' => 'integer|between:1,5',
            'user_id' => 'exists:users,id',
        ]);

        $comentario->update($validatedData);

        return response()->json($comentario);
    }

    // Eliminar un comentario
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado'], 200);
    }
}
