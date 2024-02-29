<?php
namespace App\Application;

use App\Models\Api\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getAllProducts(): Collection
    {
        return Product::all();
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function getProductById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }
}
