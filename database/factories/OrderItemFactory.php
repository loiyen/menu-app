<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'nama_menu'         => $this->faker->word(10),
            'catatan_menu'      => $this->faker->word(10),
            'qty'               => $this->faker->numberBetween(1, 10),
            'sub_total'         => $this->faker->numberBetween(10000, 50000),
            'status'            => $this->faker->randomElement(['siap','proses']),
            'order_id'          => 1,
            'menu_id'           => 1,
        ];
    }
}
