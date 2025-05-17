<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paralelo;
use Illuminate\Support\Facades\Log;

class ParaleloController extends Controller
{    /**
     * @OA\Get(
     *     path="/api/paralelos",
     *     tags={"Paralelos"},
     *     summary="Listar todos los paralelos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de paralelos obtenida correctamente"
     *     )
     * )
     */
    // Listar todos los paralelos
    public function index()
    {
        return Paralelo::all();
    }
     /**
     * @OA\Post(
     *     path="/api/paralelos",
     *     tags={"Paralelos"},
     *     summary="Crear un nuevo paralelo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", maxLength=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Paralelo creado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    // Crear un nuevo paralelo
    public function store(Request $request)
    {
        Log::info('Datos que llegan en la petición:', $request->all());

        $request->validate([
            'nombre' => 'required|string|max:100|unique:paralelos'
        ]);

        $paralelo = Paralelo::create($request->all());

        Log::info('Paralelo creado con ID: ' . $paralelo->id);

        return response()->json([
            'mensaje' => 'Paralelo creado exitosamente',
            'paralelo' => $paralelo
        ], 201);
    }
    /**
     * @OA\Get(
     *     path="/api/paralelos/{id}",
     *     tags={"Paralelos"},
     *     summary="Mostrar un paralelo específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paralelo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paralelo encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paralelo no encontrado"
     *     )
     * )
     */
    // Mostrar un paralelo específico
    public function show($id)
    {
        $paralelo = Paralelo::find($id);

        if (!$paralelo) {
            return response()->json(['mensaje' => 'Paralelo no encontrado'], 404);
        }

        return $paralelo;
    }
    /**
     * @OA\Put(
     *     path="/api/paralelos/{id}",
     *     tags={"Paralelos"},
     *     summary="Actualizar un paralelo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paralelo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", maxLength=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paralelo actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paralelo no encontrado"
     *     )
     * )
     */
    // Actualizar un paralelo
    public function update(Request $request, $id)
    {
        $paralelo = Paralelo::find($id);

        if (!$paralelo) {
            return response()->json(['mensaje' => 'Paralelo no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:100|unique:paralelos,nombre,' . $id,
        ]);

        $paralelo->update($request->all());

        return response()->json([
            'mensaje' => 'Paralelo actualizado correctamente',
            'paralelo' => $paralelo
        ]);
    }
     /**
     * @OA\Delete(
     *     path="/api/paralelos/{id}",
     *     tags={"Paralelos"},
     *     summary="Eliminar un paralelo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paralelo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paralelo eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paralelo no encontrado"
     *     )
     * )
     */
    // Eliminar un paralelo
    public function destroy($id)
    {
        $paralelo = Paralelo::find($id);

        if (!$paralelo) {
            return response()->json(['mensaje' => 'Paralelo no encontrado'], 404);
        }

        $paralelo->delete();

        return response()->json(['mensaje' => 'Paralelo eliminado correctamente']);
    }
}