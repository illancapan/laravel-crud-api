<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/students', [StudentController::class, 'index']); // Muestra todos los estudiantes
Route::get('/students/{id}', [StudentController::class, 'show']); // Muestra un estudiante por su ID
Route::post('/students', [StudentController::class, 'store'])->name('students.store'); // Crea un nuevo estudiante
Route::put('/students/{id}', [StudentController::class, 'update']); // Actualiza un estudiante
Route::delete('/students/{id}', [StudentController::class, 'destroy']); // Elimina un estudiante
