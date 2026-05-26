<?php

namespace Database\Factories;

use App\Models\Artical;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Artical>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>  fake()->text(rand(10,15)),
            'content' => fake()->text(rand(100,200)),
            'author_id' => User::factory(),
            'status' => fake()->randomElement(['draft', 'published','archived']),
            'reviewer_id' =>fake()->boolean(30) ? User::inRandomOrder()->first() : null
        ];
    }
}
