<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DatabaseSeeder extends Seeder
{
    use DatabaseMigrations;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Shop::factory(4)->create()->each(function (Shop $shop, int $index) {
            $shop->products()->saveMany(
                Product::factory(3)->make(),
                [
                    ['stock' => fake()->randomNumber()],
                    ['stock' => fake()->randomNumber()],
                    ['stock' => fake()->randomNumber()],
                ]
            );
        });
    }
}
