<?php

namespace Tests\Feature\Controllers;

use App\Models\Student;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    public function test_store_creates_student()
    {
        // Datos del estudiante
        $studentData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'language' => 'English'
        ];

        // Enviar la solicitud POST para crear el estudiante
        $response = $this->post(route('students.store'), $studentData);

        // Verificar que la respuesta tenga el estado 201 (creado)
        $response->assertStatus(201);

        // Verificar que la respuesta contenga los datos del estudiante
        $response->assertJsonFragment($studentData);

        // Verificar que los datos se hayan guardado en la base de datos
        $this->assertDatabaseHas('students', ['email' => 'john@example.com']);
    }

    public function test_store_requires_name_field()
    {
        // Datos del estudiante sin el campo "name"
        $studentData = [
            'email' => 'john@example.com',
            'phone' => '123456789',
            'language' => 'English'
        ];

        // Enviar la solicitud POST
        $response = $this->post(route('students.store'), $studentData);

        // Verificar que la respuesta sea un error 422 (validación fallida)
        $response->assertStatus(422);

        // Verificar que el error de validación esté presente para el campo "name"
        $response->assertJsonValidationErrors('name');
    }
}
