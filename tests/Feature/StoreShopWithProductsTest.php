<?php

namespace Tests\Feature;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreShopWithProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_should_create_new_shop_with_products_list(): void
    {
        $nameShop = fake()->name();
        $nameProductOne = fake()->name();
        $stockProductOne = fake()->randomNumber();

        $postData = [
            'name' => $nameShop,
            'products' => [
                [
                    'name' => $nameProductOne,
                    'stock' => $stockProductOne,
                ]
            ]
        ];

        $response = $this->post('/api/shop', $postData);

        $responseAssert = [
            'id' => 1,
            'name' => $nameShop,
            'products' => [
                [
                    'id' => 1,
                    'name' => $nameProductOne,
                    'stock' => $stockProductOne
                ]
            ]
        ];

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'status' => 'saved',
                'data'=> $responseAssert
            ]);

        /** @var Shop $shopStorage */
        $shopStorage = Shop::query()->find(1);
        $this->assertEquals($responseAssert, $shopStorage->toArray(true));
    }

    /**
     * @dataProvider getPostBodyWithAssertMessage
     */
    public function test_the_application_should_throw_error_creating_new_shop_with_wrong_arguments(
        $requestData,
        $errorMessage
    ): void {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/shop', $requestData);

        $response
            ->assertStatus(402)
            ->assertExactJson([
                'status' => 'error',
                'msg' => $errorMessage,
            ]);
    }

    public function getPostBodyWithAssertMessage(): array
    {
        return [
            'Error: The stock must be a number' => [
                [
                    'name' => fake()->name(),
                    'products' => [
                     [
                         'name' => fake()->name(),
                         'stock' => fake()->name(),
                     ]
                    ]
                ],
                'Error wrong parameters'
            ],
            'Error: The name field is required' => [
                [
                    'name' => '',
                    'products' => [
                        [
                            'name' => fake()->name(),
                            'stock' => fake()->randomNumber(),
                        ]
                    ]
                ],
                'Error wrong parameters'
            ],
            'Error: The name filed is required' => [
                [
                    'name' => fake()->name(),
                    'products' => [
                        [
                            'name' => '',
                            'stock' => fake()->randomNumber(),
                        ]
                    ]
                ],
                'Error wrong parameters'
            ]
        ];
    }
}
