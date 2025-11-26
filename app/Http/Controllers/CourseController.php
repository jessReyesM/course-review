<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function __construct()
    {
        // Aplicar middleware de autenticación a todos los métodos excepto index y show
        $this->middleware('auth')->except(['index', 'show']);

        // Forzar user_id en cada creación (backup)
        Course::creating(function ($course) {
            if (Auth::check() && empty($course->user_id)) {
                $course->user_id = Auth::id();
            }
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        // ✅ CORREGIDO: Crear manualmente con user_id
        $course = Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'instructor' => $request->instructor,
            'price' => $request->price,
            'duration' => $request->duration,
            'level' => $request->level,
            'user_id' => Auth::id() // ← ¡ESTE ERA EL PROBLEMA!
        ]);

        // DEBUG: Verificar que se creó con user_id
        \Log::info("Curso creado: {$course->title} por usuario: {$course->user_id}");

        return redirect()->route('dashboard')
            ->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // Verificar autorización usando la Policy
        if (Gate::denies('update', $course)) {
            abort(403, 'No tienes permiso para editar este curso.');
        }

        return view('courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        // Verificar autorización usando la Policy
        if (Gate::denies('update', $course)) {
            abort(403, 'No tienes permiso para actualizar este curso.');
        }

        $course->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'instructor' => $request->instructor,
            'price' => $request->price,
            'duration' => $request->duration,
            'level' => $request->level,
            // ❌ NO actualizar user_id - mantener el original
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Course $course)
    {
        // Verificar autorización usando la Policy
        if (Gate::denies('delete', $course)) {
            abort(403, 'No tienes permiso para eliminar este curso.');
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }
}