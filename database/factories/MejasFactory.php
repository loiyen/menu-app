<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\mejas>
 */
class MejasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nomor_meja' => $this->faker->unique()->numberBetween(1, 999),
            'lokasi'     => $this->faker->word(15),
        ];
    }
}
