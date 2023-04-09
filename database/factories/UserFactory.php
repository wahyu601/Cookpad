<?php

namespace Database\Factories;

use App\Models\User; //panggil model user
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(), //generate nama
            'email' => fake()->unique()->safeEmail(), //generate format email
            'role' => 'user',
            'password' => bcrypt('user'), //samakan password untuk semua user
            'status' => 'aktif',
            'last_login' => now()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
