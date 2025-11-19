<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Models\Course;

// Rutas PÚBLICAS (SSR) - Página principal
Route::get('/', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show');



Route::get('/dashboard', function () {
    $courses = Course::latest()->paginate(9);
    return view('dashboard', ['courses' => $courses]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Rutas para administrar cursos (solo autenticados)
    Route::resource('courses', CourseController::class)->except(['index', 'show']);

     // Ruta para guardar reseñas
    Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

require __DIR__.'/auth.php';