<?php

namespace App\Application;

use App\Models\Api\Sale;
use App\Models\Api\Product;

class SaleService
{
    public function createSale(array $data): Sale
    {
        $sale = Sale::create([
            'sales_id' => $data['sales_id'],
            'total_amount' => 0,
            'status' => 'pending',
        ]);

        $this->updateSaleProducts($sale, $data['products']);

        return $sale;
    }

    public function addProductToSale(Sale $sale, Product $product, int $quantity): void
    {
        $sale->products()->attach($product, ['quantity' => $quantity]);
        $sale->update(['total_amount' => $sale->total_amount + ($product->price * $quantity)]);
    }

    public function makeSale(Sale $sale): void
    {
        $sale->update(['status' => 'success']);
    }

    public function cancelSale(Sale $sale): void
    {
        $sale->update(['status' => 'canceled']);
    }

    private function updateSaleProducts(Sale $sale, array $productsData): void
    {
        $totalAmount = 0;

        foreach ($productsData as $productData) {
            $product = Product::find($productData['product_id']);

            $totalAmount += $product->price * $productData['quantity'];
            $this->addProductToSale($sale, $product, $productData['quantity']);
        }

        $sale->update(['total_amount' => $totalAmount]);
    }

}
