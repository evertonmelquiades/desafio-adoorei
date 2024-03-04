<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaleRequest;
use App\Http\Requests\Api\SaleUpdateRequest;
use App\Models\Api\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index(): JsonResponse
    {
        $sales = Sale::with('products')->get();

        return response()->json($sales);
    }

    public function store(SaleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $sale = Sale::create($data);

        $totalAmount = 0;

        foreach ($request->input('products') as $productData) {
            $product = Product::findOrFail($productData['product_id']);

            $quantity = $productData['quantity'];

            $sale->products()->attach($product->id, [
                'quantity' => $quantity,
            ]);

            $totalAmount += $product->price * $quantity;
        }

        $sale->update(['total_amount' => $totalAmount]);

        $sale->load('products');

        return response()->json(['message' => 'Sale successfully created.', 'sale' => $sale]);
    }

    public function addProduct(Sale $sale, Product $product, Request $request): JsonResponse
    {
        $data = $request->validate(['quantity' => 'required|integer|min:1']);

        $sale->products()->attach($product, ['quantity' => $data['quantity']]);

        $sale->update(['total_amount' => $sale->total_amount + ($product->price * $data['quantity'])]);

        $sale->load('products');

        return response()->json(['message' => 'The product added to sale.', 'sale' => $sale]);
    }


    public function madeSale($id): JsonResponse
    {
        $sale = Sale::findOrFail($id);

        $sale->update(['status' => 'success']);

        return response()->json(['message' => 'Sale made successfully.', 'sale' => $sale]);
    }

    public function cancel($id): JsonResponse
    {
        $sale = Sale::findOrFail($id);

        $sale->update(['status' => 'canceled']);

        return response()->json(['message' => 'Sale successfully canceled.', 'sale' => $sale]);
    }

    public function show(Sale $sale): JsonResponse
    {
        $sale->load('products');

        return response()->json($sale);
    }

    public function update(SaleUpdateRequest $request, Sale $sale): JsonResponse
    {
        $sale->update($request->validated());

        return response()->json(['message' => 'Sale successfully updated.', 'sale' => $sale]);
    }
}
