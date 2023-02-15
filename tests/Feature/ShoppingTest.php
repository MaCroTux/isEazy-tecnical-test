<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShoppingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Shop::factory(['id' => 1])->create()->each(function (Shop $shop) {
            $shop->products()->saveMany(
                [
                    Product::factory(['id' => 1])->make(),
                    Product::factory(['id' => 2])->make(),
                    Product::factory(['id' => 3])->make(),
                ],
                [
                    ['stock' => 10],
                    ['stock' => 2],
                    ['stock' => 0],
                ]
            );
        });
    }

    public function test_the_application_should_be_make_buy_product(): void
    {
        $response = $this->post('/api/shopping', [
            'shop_id' => 1,
            'product_id' => 1,
            'units' => 1
        ]);

        $response->assertStatus(201)->assertExactJson([
            'status' => 'operation_applied',
        ]);

        /** @var Shop $shopForAssert */
        $shopForAssert = Shop::query()->findOrFail(1);
        $newStockStorage = $shopForAssert->refresh()->products()
            ->withPivot('stock')
            ->findOrFail(1)
            ->getOriginal('pivot_stock');

        $this->assertSame(9, $newStockStorage);
    }

    public function test_the_application_should_be_make_buy_product_with_notification_low_stock(): void
    {
        $response = $this->post('/api/shopping', [
            'shop_id' => 1,
            'product_id' => 2,
            'units' => 1
        ]);

        $response->assertStatus(201)->assertExactJson([
            'status' => 'operation_applied',
            'msg' => 'Stock is low',
        ]);

        /** @var Shop $shopForAssert */
        $shopForAssert = Shop::query()->findOrFail(1);
        $newStockStorage = $shopForAssert->refresh()->products()
            ->withPivot('stock')
            ->findOrFail(2)
            ->getOriginal('pivot_stock');

        $this->assertSame(1, $newStockStorage);
    }

    public function test_the_application_no_buy_when_stock_is_lower_than_unis(): void
    {
        $response = $this->post('/api/shopping', [
            'shop_id' => 1,
            'product_id' => 3,
            'units' => 1
        ]);

        $response->assertStatus(402)->assertExactJson([
            'status' => 'operation_no_applied',
            'msg' => 'Out of stock',
        ]);
    }

    /**
     * @dataProvider getArgumentNotFoundProvider
     */
    public function test_application_should_throw_error_if_argument_is_incorrect(
        array $request,
        string $status,
        string $message,
        int $code
    ): void {
        $response = $this->post('/api/shopping', $request);

        $response->assertStatus($code)->assertExactJson([
            'status' => $status,
            'msg' => $message,
        ]);
    }

    public function getArgumentNotFoundProvider(): array
    {
        return [
            'Shop not exist' => [
                [
                    'shop_id' => 10,
                    'product_id' => 3,
                    'unit' => 1
                ],
                'shop_not_exist',
                'Id shop not exist.',
                404
            ],
            'Product not exist' => [
                [
                    'shop_id' => 1,
                    'product_id' => 30,
                    'unit' => 1
                ],
                'product_not_exist',
                'Id product not exit.',
                404
            ],
            'Unit is required' => [
                [
                    'shop_id' => 1,
                    'product_id' => 3,
                    'unit' => ''
                ],
                'wrong_parameter_unit',
                'Parameter unit is incorrect.',
                402
            ],
        ];
    }
}
