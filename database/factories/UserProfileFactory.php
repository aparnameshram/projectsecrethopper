<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserProfileFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'user_id' => User::factory()->create(),
            'date_of_birth' => fake()->date(),
            'gender' => 'female',
            'address' => fake()->address(),
            'latitude'  => fake()->randomNumber(),
            'longitude' => fake()->randomNumber(),
            'timezone' => fake()->timezone(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->city(),
            'country' => fake()->country(),
            'zip' => fake()->countryCode(),
            'drinker_type' => 'new',
            'how_did_hear' => fake()->text(),
            'recent_experience' => fake()->text(),
            'qualification_for_hopper' => fake()->text(),
            'acknowledge_text' => fake()->text(),
            'acknowledge_name' => fake()->name(),
            'date_signed' => fake()->date(),
            'practice_report' => false,
        ];
    }
}
