<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'author_id' => User::factory(), // This will create a relation to exactly a single user for every generated post
            'category_id' => Category::factory(), // This will create a relation to exactly a single category for every generated post
            'body' => fake()->text(),
        ];
    }
}
