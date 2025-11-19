<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize()
    {
        // Solo usuarios autenticados pueden enviar reseñas
        return auth()->check();
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:500',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'La calificación es obligatoria',
            'rating.between' => 'La calificación debe ser entre 1 y 5 estrellas',
            'comment.required' => 'El comentario es obligatorio',
            'comment.min' => 'El comentario debe tener al menos 10 caracteres',
            'comment.max' => 'El comentario no puede exceder 500 caracteres',
        ];
    }
}