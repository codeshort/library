<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return 
        [
            'title' => $this->faker->sentence,
            'author_id' => Author::factory(),
        ];
    }
}
