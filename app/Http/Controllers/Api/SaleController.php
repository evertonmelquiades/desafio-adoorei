<?php

namespace App\Http\Controllers\Api;

use App\Application\SaleService;
use App\Models\Api\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaleRequest;
use App\Http\Requests\Api\SaleUpdateRequest;
use App\Models\Api\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index(): JsonResponse
    {
        $sales = Sale::with('products')->get();
        return response()->json($sales);
    }

    public function store(SaleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $sale = $this->saleService->createSale($data);
        return response()->json(['message' => 'Sale successfully created.', 'sale' => $sale]);
    }

    public function addProduct(Sale $sale, Product $product, Request $request): JsonResponse
    {
        $data = $request->validate(['quantity' => 'required|integer|min:1']);
        $this->saleService->addProductToSale($sale, $product, $data['quantity']);
        return response()->json(['message' => 'The product added to sale.', 'sale' => $sale]);
    }

    public function madeSale($id): JsonResponse
    {
        $sale = Sale::findOrFail($id);
        $this->saleService->makeSale($sale);
        return response()->json(['message' => 'Sale made successfully.', 'sale' => $sale]);
    }

    public function cancel($id): JsonResponse
    {
        $sale = Sale::findOrFail($id);
        $this->saleService->cancelSale($sale);
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
