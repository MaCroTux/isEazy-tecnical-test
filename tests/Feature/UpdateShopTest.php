<?php

namespace Tests\Feature;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_should_update_shop_with_request_data(): void
    {
        $shopName = fake()->name();
        Shop::factory(['id' => 10])->create();

        $requestData = [
            'id' => 10,
            'name' => $shopName,
        ];

        $response = $this->put('/api/shop', $requestData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'edited'
            ]);

        $this->assertSame($shopName, Shop::all()->find(10)->getAttribute('name'));
    }

    public function test_the_application_should_throw_error_when_update_shop_with_argument_error(): void
    {
        Shop::factory(['id' => 1])->create();
        $response = $this->put('/api/shop', ['id' => 1, 'name' => '']);

        $response
            ->assertStatus(402)
            ->assertExactJson([
                'status' => 'error',
                'msg' => 'Error wrong parameters',
            ]);
    }

    public function test_the_application_return_404_when_resource_not_found(): void
    {
        Shop::factory(['id' => 20])->create();
        $requestData = [
            'id' => 10,
            'name' => fake()->name(),
        ];

        $response = $this->put('/api/shop', $requestData);

        $response
            ->assertStatus(404)
            ->assertJson([
                'status' => 'not_found'
            ]);
    }
}
