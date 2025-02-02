<?php

namespace App\Services;


use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentService
{

    public function getAllStudents()
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            return [
                'status' => 404,
                'data' => [
                    'message' => 'No hay estudiantes registrados',
                    'status' => 404,
                ],
            ];
        }
        return [
            'status' => 200,
            'data' => $students,
        ];
    }

    public function createStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 400,
                'data' => [
                    'message' => 'Error en la validación',
                    'error' => $validator->errors(),
                ],
                'status' => 400,
            ];
        }

        $student = Student::create($request->all());

        if (!$student) {
            return [
                'data' => [
                    'message' => 'Error al crear Estudiante',
                    'status' => 500,
                ],
            ];
        }

        return [
            'data' => [
                'message' => 'Estudiante creado correctamente',
                'student' => $student,
            ],
            'status' => 201,
        ];
    }
}
