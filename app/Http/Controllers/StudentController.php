<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Estudiantes",
 *     version="1.0.0",
 *     description="Documentación de la API para gestionar estudiantes"
 * )
 * @OA\PathItem(
 *     path="/api/students"
 * )
 */
class StudentController extends Controller
{
    /**
     * Display a listing of students.
     *
     * @OA\Get(
     *     path="/api/students",
     *     tags={"Students"},
     *     summary="Obtener lista de estudiantes",
     *     description="Retorna todos los estudiantes registrados en el sistema",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="carnet", type="string", example="20210001"),
     *                     @OA\Property(property="name", type="string", example="Juan"),
     *                     @OA\Property(property="lastname", type="string", example="Pérez García"),
     *                     @OA\Property(property="email", type="string", example="juan.perez@universidad.edu"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2026-02-03T05:41:38.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2026-02-03T05:41:38.000000Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $students = Student::all();
        
        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }
    
    /**
     * Display a listing of students in a web view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexWeb()
    {
        $students = Student::all();
        
        return view('students.index', compact('students'));
    }
}