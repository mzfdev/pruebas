<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="API de Estudiantes",
 *     version="1.0.0",
 *     description="Documentación de la API para gestionar estudiantes"
 * )
 */
class SwaggerDefinitions
{
    /**
     * @OA\Schema(
     *     schema="Student",
     *     type="object",
     *     title="Student",
     *     required={"id", "carnet", "name", "lastname", "email"},
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="carnet", type="string", example="20210001"),
     *     @OA\Property(property="name", type="string", example="Juan"),
     *     @OA\Property(property="lastname", type="string", example="Pérez García"),
     *     @OA\Property(property="email", type="string", example="juan.perez@universidad.edu"),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2026-02-03T05:41:38.000000Z"),
     *     @OA\Property(property="updated_at", type="string", format="date-time", example="2026-02-03T05:41:38.000000Z")
     * )
     */
    public function Student()
    {
    }
}