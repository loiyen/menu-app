<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\pembayarans>
 */
class PembayaransFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'metode' => $this->faker->randomElement(['tunai', 'transfer']),
            'jumlah_bayar'  => $this->faker->numberBetween(10000, 1000000), // Bayar antara 10rb - 1jt
            'status' => $this->faker->randomElement(['menunggu', 'lunas', 'gagal']),
            'waktu_bayar'   => $this->faker->dateTimeBetween('-7 days', 'now'),
            'orders_id'      => $this->faker->numberBetween(1, 100)
        ];
    }
}
