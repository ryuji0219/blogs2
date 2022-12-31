<?php

namespace Database\Factories;

use App\Modes\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

// use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'content' => $this->faker->realText,
            'user_id'=> $this->faker->numberBetween(1, 3),
        ];
    }
}
