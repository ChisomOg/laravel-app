<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'tags' => fake()->words(5, true),
            'company' => fake()->company(),
            'email' => fake()->email(),
            'website' => fake()->url(),
            'location' => fake()->city(),
            'description' => fake()->paragraph(4)
        ];
    }
}
