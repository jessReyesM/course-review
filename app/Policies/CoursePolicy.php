<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Determinar si el usuario puede ver cualquier curso.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver cursos
    }

    /**
     * Determinar si el usuario puede ver el curso.
     */
    public function view(User $user, Course $course): bool
    {
        return true; // Todos pueden ver cursos individuales
    }

    /**
     * Determinar si el usuario puede crear cursos.
     */
    public function create(User $user): bool
    {
        return true; // Todos los usuarios autenticados pueden crear cursos
    }

    /**
     * Determinar si el usuario puede actualizar el curso.
     */
    public function update(User $user, Course $course): bool
    {
        // Admin puede editar todo, usuarios normales solo sus cursos
        return $user->role === 'admin' || $user->id === $course->user_id;
    }

    /**
     * Determinar si el usuario puede eliminar el curso.
     */
    public function delete(User $user, Course $course): bool
    {
        // Admin puede eliminar todo, usuarios normales solo sus cursos
        return $user->role === 'admin' || $user->id === $course->user_id;
    }
}