<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class studentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        $result = $this->studentService->getAllStudents();
        return response()->json($result['data'], $result['status']);
    }
    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string',
            'language' => 'required|string',
        ]);

        // Crear el estudiante
        $student = Student::create($validatedData);

        // Retornar una respuesta con el código 201
        return response()->json($student, 201);
    }
}
