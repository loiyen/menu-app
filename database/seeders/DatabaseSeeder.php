<?php

namespace Database\Seeders;

use App\Models\kategoris;
use App\Models\mejas;
use App\Models\menus;
use App\Models\OrderItem;
use App\Models\order;
use App\Models\pembayarans;
use App\Models\subkategoris;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         User::factory(5)->create();
         kategoris::factory(1)->create();
         mejas::factory(5)->create();
         menus::factory(10)->create();
        //  orders::factory(10)->create();
        //  OrderItem::factory(5)->create();
        //  pembayarans::factory(5)->create();
    }
}
