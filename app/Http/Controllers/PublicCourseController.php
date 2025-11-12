<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class PublicCourseController extends Controller
{
    /**
     * Display a listing of the courses (Home page)
     */
    public function index(): View
    {
        // Obtenemos los cursos (paginados) - SSR
        $courses = Course::latest()->paginate(10);
        
        // Renderizamos la vista Blade y le pasamos los datos
        return view('home', ['courses' => $courses]);
    }

    /**
     * Display the specified course
     */
    public function show(Course $course): View
    {
        // Cargamos el curso y sus reseñas (Eager Loading para optimizar queries)
        $course->load('reviews.user');
        
        // Renderizamos la vista de detalle
        return view('courses.show', ['course' => $course]);
    }
}