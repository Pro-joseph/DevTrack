<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'role' => fake()->randomElement(['admin', 'member', 'viewer']),
        ];
    }
}