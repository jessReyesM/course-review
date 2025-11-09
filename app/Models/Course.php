<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'instructor',
        'price',
        'duration',
        'level'
    ];

    // Relación con reseñas
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // (Opcional pero recomendado) Para URLs amigables
    public function getRouteKeyName()
    {
        return 'slug'; // Para usar el slug en la URL en lugar del ID
    }

    // Métodos útiles para estadísticas
    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function totalReviews(): int
    {
        return $this->reviews()->count();
    }
}