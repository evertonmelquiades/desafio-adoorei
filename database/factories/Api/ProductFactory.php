<?php

namespace Database\Factories\Api;

use App\Models\Api\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define o modelo de fábrica e seus estados padrão.
     *
     * @return array
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1000, 10000),
            'description' => $this->faker->sentence,
        ];
    }
}
