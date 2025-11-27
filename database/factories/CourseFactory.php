<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'instructor' => $this->faker->name(),
            'duration' => $this->faker->randomNumber(2),
            'level' => $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'price' => $this->faker->randomFloat(2, 0, 100),
            // Agrega más campos según tu modelo Course
        ];
    }
}