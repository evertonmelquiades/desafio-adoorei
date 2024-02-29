<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Api\Sale;
use App\Models\Api\Product;
use Illuminate\Support\Facades\DB;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define o modelo de fábrica e seus estados padrão.
     *
     * @return array
     */
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'sales_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'total_amount' => 0,
            'status' => 'pending',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Sale $sale) {
            $products = DB::table('products')->inRandomOrder()->limit(3)->pluck('id')->toArray();

            foreach ($products as $productId) {
                $quantity = $this->faker->numberBetween(1, 5);
                $sale->products()->attach($productId, ['quantity' => $quantity]);
                $sale->total_amount += $quantity * DB::table('products')->where('id', $productId)->value('price');
            }

            $sale->update(['total_amount' => $sale->total_amount]);
        });
    }
}
