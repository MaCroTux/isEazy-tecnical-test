<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowDescriptionShopWithProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_should_return_shop_description(): void
    {
        $shopsCreated = Shop::factory(2)
            ->hasAttached(Product::factory(3), ['stock' => 10], 'products')
            ->create();

        $response = $this->get('/api/shop/' . $shopsCreated->last()->getAttribute('id'));

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertSimilarJson($this->parseModelToJsonResponse($shopsCreated->last()));
    }

    private function parseModelToJsonResponse(Model $shop): array
    {
        return [
            'id' => $shop->getAttribute('id'),
            'name' => $shop->getAttribute('name'),
            'products' => array_map(function (array $product) {
                return [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'stock' => $product['stock']
                ];
            }, $shop->getAttribute('products')->toArray() ?? [])
        ];
    }
}
