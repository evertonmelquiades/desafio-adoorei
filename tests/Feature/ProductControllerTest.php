<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Api\Product;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $controller = new ProductController();

        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $data = [
            'name' => 'Produto de Teste',
            'price' => 19.99,

        ];

        $response = $this->json('POST', route('products.store'), $data);

        $response->assertJson($data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', $data);
    }

    public function testShow()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 19.99,
        ]);

        $controller = new ProductController();

        $response = $controller->show($product);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertEquals($product->id, $content['id']);
    }

    public function testUpdate()
    {
        $product = Product::factory()->create()->first();

        $productId = $product->id;

        $data = [
            'name' => 'Produto de Teste',
            'price' => 19.99,
        ];

        $response = $this->json('PUT', route('products.update', ['product' => $productId]), $data);

        $response->assertJson($data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', $data);
    }

    public function testDestroy()
    {
        $product = Product::factory()->create();

        $productId = $product->id;

        $response = $this->json('DELETE', route('products.destroy', ['product' => $productId]));

        $response->assertStatus(204);

        $deletedProduct = Product::find($productId);

        $this->assertNull($deletedProduct, 'O produto não foi removido do banco de dados.');
    }
}
