<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\menus>
 */
class MenusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(10),
            'harga'=> $this->faker->numberBetween(100000, 9999999),
            'stok' => $this->faker->numberBetween(1, 1000),
            'gambar' => $this->faker->imageUrl(640, 480, 'products', true),
            'kategori_id' => 1
        ];
    }
}
