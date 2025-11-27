<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Usuario autenticado PUEDE enviar una reseña
     */
    public function test_authenticated_user_can_submit_review()
    {
        // Arrange: Crear usuario, curso y autenticar
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $this->actingAs($user);

        // Act: Enviar datos de la reseña
        $reviewData = [
            'rating' => 5,
            'comment' => 'Excelente curso, muy recomendado!',
            'course_id' => $course->id,
        ];

        $response = $this->post("/curso/{$course->id}/reviews", $reviewData);

        // Assert: Verificar que se creó la reseña y redirige
        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'rating' => 5,
            'comment' => 'Excelente curso, muy recomendado!',
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Test: Usuario NO autenticado NO PUEDE enviar reseña (redirección al login)
     */
    public function test_guest_cannot_submit_review()
    {
        // Arrange: Crear un curso (sin usuario autenticado)
        $course = Course::factory()->create();

        // Act: Intentar enviar reseña sin autenticación
        $reviewData = [
            'rating' => 4,
            'comment' => 'Bueno, pero podría mejorar',
            'course_id' => $course->id,
        ];

        $response = $this->post("/curso/{$course->id}/reviews", $reviewData);

        // Assert: Verificar redirección al login
        $response->assertRedirect('/login');
    }
}