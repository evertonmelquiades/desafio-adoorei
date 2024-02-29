<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Sale;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::factory(10)->create();
    }
}
