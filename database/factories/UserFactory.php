<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
         $this->createDefaultUsersOnce();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role'=> fake()->randomElement(['writer', 'reader']),
            'profile' => json_encode([
                'bio' => fake()->paragraph(),
                'avatar' => fake()->imageUrl(),]),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */


    public static function createDefaultUsersOnce(): void
    {
        static $created = false;

        if ($created) {
            return;
        }

        $created = true;


        User::updateOrCreate(
            ['email' => 'admin@NewsRoom.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'profile' =>'{"bio":" admin bio .","avatar":"https:\/\/via.placeholder.com\/640x480.png\/006600?text=possimus"}',
                'email_verified_at' => now(),
            ]
        );




        User::updateOrCreate(
            ['email' => 'reader@NewsRoom.com'],
            [
                'name' => 'reader User',
                'password' => Hash::make('reader123'),
                'role' => 'admin',
                'profile' =>'{"bio":" reader bio .","avatar":"https:\/\/via.placeholder.com\/640x480.png\/006600?text=possimus"}',
                'email_verified_at' => now(),
            ]
        );


        User::updateOrCreate(
            ['email' => 'writer@NewsRoom.com'],
            [
                'name' => 'writer User',
                'password' => Hash::make('writer123'),
                'role' => 'admin',
                'profile' =>'{"bio":" writer bio .","avatar":"https:\/\/via.placeholder.com\/640x480.png\/006600?text=possimus"}',
                'email_verified_at' => now(),
            ]
        );

    }


    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
