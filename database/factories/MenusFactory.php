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
        $namaMenuKopi = [
            'Espresso',
            'Americano',
            'Cappuccino',
            'Latte',
            'Mocha',
            'Macchiato',
            'Flat White',
            'Long Black',
            'Cold Brew',
            'Affogato',
            'Vietnam Drip',
            'Kopi Tubruk',
            'Kopi Susu Gula Aren',
            'Frappuccino',
            'Irish Coffee',
        ];

        return [
            'nama' => $this->faker->randomElement($namaMenuKopi),
            'harga'=> $this->faker->numberBetween(10000, 60000),
            'stok' => $this->faker->numberBetween(1, 100),
            'gambar' => $this->faker->imageUrl(640, 480, 'coffee', true),
            'kategori_id' => 1
        ];
    }
}
