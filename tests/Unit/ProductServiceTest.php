<?php

namespace Tests\Feature;

use App\Application\ProductService;
use App\Models\Api\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ProductService */
    private $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = new ProductService();
    }

    /** @test */
    public function it_can_get_all_products()
    {
        // Criar três produtos no banco de dados usando a fábrica
        Product::factory()->count(3)->create();

        // Obter todos os produtos usando o ProductService
        $products = $this->productService->getAllProducts();

        // Verificar se a contagem de produtos é igual a 3
        $this->assertCount(3, $products);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'name' => 'Test Product',
            'price' => 1999.99,
        ];

        $product = $this->productService->createProduct($productData);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        // Crie um produto para atualizar
        $product = Product::factory()->create();

        // Dados a serem atualizados
        $updatedData = ['name' => 'Updated Product'];

        // Chame o método updateProduct
        $updatedProduct = $this->productService->updateProduct($product, $updatedData);

        // Recarregue o produto do banco de dados para obter os dados mais recentes
        $refreshedProduct = Product::find($product->id);

        // Faça as asserções necessárias
        $this->assertEquals($updatedData['name'], $updatedProduct->name);
        $this->assertEquals($updatedData['name'], $refreshedProduct->name);
        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        // Crie um único produto para deletar
        $product = Product::factory(1)->create()->first();

        // Chame o método deleteProduct com a instância correta
        $this->productService->deleteProduct($product);

        // Faça a asserção para garantir que o produto foi removido do banco de dados
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
