<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'budget' => $this->faker->numberBetween(500, 2000),
            'skills' => ['Laravel', 'React'],
            'platform' => 'Manual',
            'url' => $this->faker->url(),
            'dedupe_hash' => $this->faker->sha256(),
            'status' => 'new',
        ];
    }
}
