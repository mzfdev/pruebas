<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Students endpoints
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}/grade-report', [StudentController::class, 'gradeReport']);

// Reports endpoints
Route::post('/reports/generate-pdf', [ReportController::class, 'generatePdf']);
Route::get('/reports/download/{fileName}', [ReportController::class, 'downloadPdf']);