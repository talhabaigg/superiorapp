<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Helpers\AvatarHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $avatarPath = AvatarHelper::generateAvatar($name);
        
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'avatar' =>  $avatarPath,
            'employee_type' => $this->faker->randomElement(['Foreman', 'Plasterer', 'Leading Hand']),
            'superior_id' => 'SUP' . random_int(100, 999),
            'greenline_id' => 'GRE' . random_int(100, 999),
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
