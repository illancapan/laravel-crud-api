<?php

namespace App\Services;

use App\Models\Student;
use App\Http\Requests\CreateStudentRequest;
use Illuminate\Support\Facades\Validator;

class StudentService
{
    public function getAllStudents()
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            return [
                'status' => 204, // Código 204 para no contenido
                'data' => [
                    'message' => 'No se encontraron estudiantes',
                    'status' => 204,
                ],
            ];
        }

        return [
            'status' => 200,
            'data' => $students,
        ];
    }

    public function createStudent(CreateStudentRequest $request)
    {
        try {
            $student = Student::create($request->validated()); // Usamos los datos validados

            return [
                'status' => 201,
                'data' => [
                    'message' => 'Estudiante creado correctamente',
                    'student' => $student,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'data' => [
                    'message' => 'Error al crear Estudiante',
                    'error' => $e->getMessage(),
                ],
            ];
        }
    }
}
