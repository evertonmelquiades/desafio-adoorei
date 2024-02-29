<?php

namespace App\Http\Controllers\Api;

use App\Application\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Api\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return response()->json($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = $this->productService->createProduct($data);
        return response()->json($product);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        $updatedProduct = $this->productService->updateProduct($product, $data);
        return response()->json($updatedProduct);
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        return response()->noContent();
    }
}
