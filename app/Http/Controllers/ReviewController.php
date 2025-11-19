<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        // Validación básica
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        // Crear la reseña
        Review::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '¡Reseña publicada correctamente!');
    }
}