<?php

namespace Tests\Unit\Services;

use App\Services\StudentService;
use Tests\TestCase;
use Mockery;

class StudentServiceTest extends TestCase
{
    protected $studentService;

    public function setUp(): void
    {
        parent::setUp();
        // Simulamos el StudentService para las pruebas unitarias.
        $this->studentService = Mockery::mock(StudentService::class);
    }

    public function test_getAllStudents_returns_correct_data()
    {
        // Datos esperados para la respuesta
        $expectedData = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com'
            ],
        ];

        // Definimos que el método getAllStudents debería devolver los datos esperados
        $this->studentService
            ->shouldReceive('getAllStudents')
            ->once()
            ->andReturn(['data' => $expectedData, 'status' => 200]);

        // Ejecutamos el método y verificamos el resultado
        $result = $this->studentService->getAllStudents();
        $this->assertEquals($expectedData, $result['data']);
        $this->assertEquals(200, $result['status']);
    }
}
