<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{    /**
     * @OA\Get(
     *     path="/api/estudiantes",
     *     tags={"Estudiantes"},
     *     summary="Listar todos los estudiantes",
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso"
     *     )
     * )
     */
    // Listar todos los estudiantes
    public function index()
    {
        return response()->json(Estudiante::with('paralelo')->get(), 200);
    }
      /**
     * @OA\Post(
     *     path="/api/estudiantes",
     *     tags={"Estudiantes"},
     *     summary="Crear un nuevo estudiante",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"nombre", "cedula", "correo", "paralelo_id"},
     *              @OA\Property(property="nombre", type="string"),
     *              @OA\Property(property="cedula", type="string"),
     *              @OA\Property(property="correo", type="string", format="email"),
     *              @OA\Property(property="paralelo_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estudiante creado"
     *     )
     * )
     */
    // Crear un nuevo estudiante
    public function store(Request $request)
    {
        Log::info('Request data: ', $request->all());
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|unique:estudiantes,cedula',
            'correo' => 'required|email|unique:estudiantes,correo',
            'paralelo_id' => 'required|exists:paralelos,id'
        ]);

        $estudiante = Estudiante::create($request->all());

        return response()->json([
            'mensaje' => 'Estudiante creado correctamente',
            'estudiante' => $estudiante
        ], 201);
    }
      /**
     * @OA\Get(
     *     path="/api/estudiantes/{id}",
     *     tags={"Estudiantes"},
     *     summary="Mostrar un estudiante específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudiante",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    // Mostrar un estudiante específico
    public function show($id)
    {
        $estudiante = Estudiante::with('paralelo')->find($id);

        if (!$estudiante) {
            return response()->json(['mensaje' => 'Estudiante no encontrado'], 404);
        }

        return response()->json($estudiante);
    }
    /**
     * @OA\Put(
     *     path="/api/estudiantes/{id}",
     *     tags={"Estudiantes"},
     *     summary="Actualizar un estudiante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudiante",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string"),
     *              @OA\Property(property="cedula", type="string"),
     *              @OA\Property(property="correo", type="string", format="email"),
     *              @OA\Property(property="paralelo_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    // Actualizar un estudiante
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['mensaje' => 'Estudiante no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'cedula' => 'sometimes|required|unique:estudiantes,cedula,' . $id,
            'correo' => 'sometimes|required|email|unique:estudiantes,correo,' . $id,
            'paralelo_id' => 'sometimes|required|exists:paralelos,id',
        ]);

        $estudiante->update($validated);

        return response()->json([
            'mensaje' => 'Estudiante actualizado correctamente',
            'estudiante' => $estudiante
        ]);
    }
     /**
     * @OA\Delete(
     *     path="/api/estudiantes/{id}",
     *     tags={"Estudiantes"},
     *     summary="Eliminar un estudiante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudiante",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    // Eliminar un estudiante
    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['mensaje' => 'Estudiante no encontrado'], 404);
        }

        $estudiante->delete();

        return response()->json(['mensaje' => 'Estudiante eliminado correctamente']);
    }
}
