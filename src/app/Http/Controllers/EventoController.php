<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        // Recuperar todos los eventos
        $eventos = Evento::all();

        // Preparar respuesta
        $respuesta = [
            'eventos' => $eventos,
            'status' => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Almacenar un recurso recién creado.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);

        // Verificar si falló la validación
        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400,
            ];

            return response()->json($respuesta, 400);
        }

        // Crear el evento
        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'ubicacion' => $request->ubicacion,
        ]);

        // Verificar si ocurrió un error
        if (!$evento) {
            $respuesta = [
                'message' => 'Error al crear el evento',
                'status' => 500,
            ];

            return response()->json($respuesta, 500);
        }

        // Retornar el evento creado
        $respuesta = [
            'evento' => $evento,
            'status' => 201,
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Mostrar un recurso específico.
     */
    public function show($id)
    {
        // Buscar evento por ID
        $evento = Evento::find($id);

        // Verificar si existe
        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status' => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $respuesta = [
            'evento' => $evento,
            'status' => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Actualizar un recurso específico.
     */
    public function update(Request $request, $id)
    {
        // Buscar evento
        $evento = Evento::find($id);

        // Verificar si existe
        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status' => 404,
            ];

            return response()->json($respuesta, 404);
        }

        // Validar datos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400,
            ];

            return response()->json($respuesta, 400);
        }

        // Actualizar datos
        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin = $request->fecha_fin;
        $evento->ubicacion = $request->ubicacion;

        $evento->save();

        $respuesta = [
            'evento' => $evento,
            'status' => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Eliminar un recurso específico.
     */
    public function destroy($id)
    {
        // Buscar evento
        $evento = Evento::find($id);

        // Verificar si existe
        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status' => 404,
            ];

            return response()->json($respuesta, 404);
        }

        // Eliminar evento
        $evento->delete();

        $respuesta = [
            'message' => 'Evento eliminado',
            'status' => 200,
        ];

        return response()->json($respuesta, 200);
    }
}
