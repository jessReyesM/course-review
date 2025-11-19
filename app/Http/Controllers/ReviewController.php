<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Course $course)
    {
        // Crear la reseña
        Review::create([
            'user_id' => auth()->id(),      // Usuario autenticado
            'course_id' => $course->id,     // Del curso en la URL
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redirigir con mensaje de éxito
        return back()->with('success', '¡Reseña publicada correctamente!');
    }
}