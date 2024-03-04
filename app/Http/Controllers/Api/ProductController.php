<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Api\Product;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Product::create($data);

        return response()->json($product);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        $product->update($data);

        return response()->json($data);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
