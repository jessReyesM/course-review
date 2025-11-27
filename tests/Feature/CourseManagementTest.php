<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Usuario NO autenticado NO puede acceder a crear curso (redirección al login)
     */
    public function test_guest_cannot_create_course()
    {
        // Act: Intentar acceder a la página de crear curso sin estar autenticado
        $response = $this->get('/courses/create');

        // Assert: Verificar que redirige al login
        $response->assertRedirect('/login');
    }

    /**
     * Test: Usuario autenticado SÍ puede crear curso
     */
    public function test_authenticated_user_can_create_course()
    {
        // Arrange: Crear y autenticar un usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act 1: Acceder a la página de crear curso
        $response = $this->get('/courses/create');
        
        // Assert 1: Verificar que puede acceder (código 200)
        $response->assertStatus(200);
        $response->assertSee('Crear Nuevo Curso'); // Verificar que ve el formulario

        // Act 2: Enviar el formulario para crear un curso
        $courseData = [
            'title' => 'Nuevo Curso de Prueba',
            'description' => 'Descripción del curso de prueba',
            'instructor' => 'Instructor de Prueba',
            'price' => 99.99,
            'duration' => 30,
            'level' => 'intermediate'
        ];

        $response = $this->post('/courses', $courseData);

        // Assert 2: Verificar que el curso se creó y redirige correctamente
        $response->assertRedirect(); // Verifica que hay redirección
        $this->assertDatabaseHas('courses', [
            'title' => 'Nuevo Curso de Prueba',
            'instructor' => 'Instructor de Prueba'
        ]);
    }
}