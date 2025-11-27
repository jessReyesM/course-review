<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_home_page_loads_successfully()
    {
        // Verifica un código 200 en /
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_home_page_displays_courses()
    {
        // Verifica que un curso creado aparece en la vista
        $course = Course::factory()->create();
        
        $response = $this->get('/');
        $response->assertSee($course->title);
    }

    /** @test */
    public function test_course_detail_page_loads()
    {
        // Verifica el detalle del curso
        $course = Course::factory()->create();
        
        //$response = $this->get('/curso/' . $course->id);
        $response = $this->get(route('courses.show', $course));
        $response->assertStatus(200);
        $response->assertSee($course->title);
    }
}