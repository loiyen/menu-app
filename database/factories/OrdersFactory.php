<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'     => strtoupper(Str::random(10)), 
            'nama'         => $this->faker->word(10),
            'meja_id'      => $this->faker->numberBetween(1, 10),
            'waktu_pesan'  => $this->faker->dateTime(),
            'opsi'         => $this->faker->randomElement(['Normal', 'Less', 'Tanpa gula']),
            'status'       => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_status'  => $this->faker->randomElement(['unpaid', 'paid', 'failed']),
            'catatan'      => $this->faker->sentence(),
            'total_harga'  => $this->faker->numberBetween(10000, 900000),

        ];
    }
}
