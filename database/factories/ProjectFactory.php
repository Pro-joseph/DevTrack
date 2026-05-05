<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'deadline' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['planning', 'active', 'on_hold', 'completed']),
        ];
    }
}