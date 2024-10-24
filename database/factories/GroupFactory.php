<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'claim_limit' => fake()->numberBetween(1, 5),
            'radius' => fake()->randomDigit(),
            'unique_instructions' => fake()->text(),
            'show_in_search' => true
        ];
    }
}
