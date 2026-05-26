<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Tag::class;
    public function definition(): array
    {
        $base=fake()->unique()->word();
        $uniqueSuffix=uniqid();
        return [
            'name'=>$base.'_'.$uniqueSuffix,//fake()->unique()->word(),
            'slug'=>Str::slug($base.'_'.$uniqueSuffix),
        ];
    }
}
