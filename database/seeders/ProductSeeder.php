<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Product;
use Database\Factories\Api\ProductFactory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Product::factory(10)->create();
    }
}
