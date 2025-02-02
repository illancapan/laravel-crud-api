<?php

namespace Tests\Unit\Services;

use App\Models\Student;
use App\Services\StudentService;
use App\Http\Requests\CreateStudentRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Tests\TestCase;

class StudentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $studentService;

    public function setUp(): void
    {
        parent::setUp();

        $this->studentService = app(StudentService::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_getAllStudents_returns_correct_data()
    {
        Student::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $result = $this->studentService->getAllStudents();

        $this->assertEquals(200, $result['status']);
        $this->assertCount(1, $result['data']);  // Verifica que el número de estudiantes sea correcto
    }

    public function test_getAllStudents_returns_204_when_no_students_found()
    {
        $result = $this->studentService->getAllStudents();

        $this->assertEquals(204, $result['status']);
        $this->assertEquals('No se encontraron estudiantes', $result['data']['message']);
    }

    public function test_createStudent_successfully()
    {
        $request = Request::create('/students', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'language' => 'English',
        ]);

        $result = $this->studentService->createStudent($request);

        $this->assertEquals(201, $result['status']);
        $this->assertEquals('Estudiante creado correctamente', $result['data']['message']);
        $this->assertDatabaseHas('students', ['email' => 'john@example.com']);
    }

    public function test_createStudent_validation_fails()
    {
        $request = Request::create('/students', 'POST', []); // Datos vacíos para invalidar la solicitud

        $result = $this->studentService->createStudent($request);

        $this->assertEquals(400, $result['status']);
        $this->assertEquals('Error en la validación', $result['data']['message']);
    }
}
