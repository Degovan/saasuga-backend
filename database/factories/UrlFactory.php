<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Url>
 */
class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'destination' => fake()->url(),
            'keyword' => fake()->word(),
            'expiration' => Carbon::now()->addMonth(3),
            'title' => fake()->word(),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ];
    }
}
