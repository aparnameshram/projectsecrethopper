<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),

            'radius' => 2,
            'latitude'  => fake()->randomNumber(),
            'longitude' => fake()->randomNumber(),
            'timezone' => fake()->timezone(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->city(),
            'country' => fake()->country(),
            'zip' => fake()->countryCode(),
            'questionnaire_link'  => fake()->url(),
            'unique_instructions' => fake()->text(),
        ];
    }
    //'text'
}
