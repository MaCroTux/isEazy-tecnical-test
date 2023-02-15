<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetShopListTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_return_a_shops_list_with_product_relation(): void
    {
        $shopsCreated = Shop::factory(2)
            ->hasAttached(Product::factory(3), ['stock' => 10], 'products')
            ->create();

        $response = $this->get('/api/shops');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertSimilarJson($this->parseModelCollectionToJsonResponse($shopsCreated));
    }

    private function parseModelCollectionToJsonResponse(Collection $shops): array
    {
        $result = [];
        foreach ($shops as $shop) {
            $result[] = $this->parseModelToJsonResponse($shop);
        }

        return $result;
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
                ];
            }, $shop->getAttribute('products')->toArray() ?? [])
        ];
    }
}
