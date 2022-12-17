<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->domainName(),
            'file_name' => Str::random(10),
            'check_in' => fake()->boolean(0),
            'mime_type' => fake()->fileExtension(),
            'path' => fake()->filePath(),
            'size' => fake()->randomNumber(6),
            //'user_id' => fake()->numberBetween(1,50)
        ];
    }
}
