<?php

use App\Models\group;
use App\Models\Role;
use App\Models\Timeslot;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\venue;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678'
        ]);*/

        $admin = Role::factory()->create([
            'name' => 'admin'
        ]);
        $user = User::factory()->create([
            'first_name' => 'Admin User',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '12345678',
            'role_id' => $admin
        ]);
        UserProfile::factory()->create([
            'user_id' => $user
        ]);

        $manager = Role::factory()->create([
            'name' => 'manager'
        ]);
        $user = User::factory()->create([
            'first_name' => 'Manager User',
            'last_name' => 'manager',
            'email' => 'manager@example.com',
            'password' => '12345678',
            'role_id' => $manager
        ]);
        UserProfile::factory()->create([
            'user_id' => $user
        ]);
        $user = Role::factory()->create([
            'name' => 'user'
        ]);

        /*User::factory(3)
            ->state(new Sequence(
                fn(Sequence $sequence) => ['role_id' => Role::all()->random()],
            ))
            ->has(UserProfile::factory()->count(1), 'userProfile')
            ->has(
                venue::factory()
                    ->has(group::factory()
                        ->has(
                            Timeslot::factory()->count(2)
                        )
                        ->hasAttached(User::factory()->count(3))
                        ->count(2))
                    ->count(2)
            )
            ->create();*/
        User::factory(3)
            ->state(new Sequence(
                fn(Sequence $sequence) => ['role_id' => Role::all()->random()],
            ))
            ->has(UserProfile::factory()->count(1), 'userProfile')
            ->has(
                venue::factory()
                    ->has(group::factory()
                        ->has(
                            Timeslot::factory()->count(2)
                        )
                        ->hasAttached(
                            User::factory()
                                ->has(UserProfile::factory()->count(1), 'userProfile')
                                ->count(3)
                        )
                        ->count(2))
                    ->count(2)
            )
            ->create();
    }
}
