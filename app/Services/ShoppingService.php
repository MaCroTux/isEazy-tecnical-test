<?php

namespace App\Services;

use App\Models\Shop;

class ShoppingService
{
    private Shop $shopModel;

    public function __construct(Shop $shopModel)
    {
        $this->shopModel = $shopModel;
    }

    /**
     * Realiza una compra en la aplicación y decrementa las unidades enviadas
     *
     * @param int $shopId
     * @param int $productId
     * @param int $units
     * @return ShoppingResponse
     */
    public function __invoke(int $shopId, int $productId, int $units): ShoppingResponse
    {
        /** @var Shop $shop */
        $shop = $this->shopModel->query()->findOrFail($shopId);
        $product = $shop->products()->withPivot('stock')->findOrFail($productId);
        $stock = (int)$product->getOriginal('pivot_stock');

        if ($stock === 0 || $stock < $units) {
            return new ShoppingResponse(
                'operation_no_applied',
                402,
                'Out of stock'
            );
        }

        $shop->products()->updateExistingPivot($product->getAttribute('id'), ['stock' => $stock - $units]);

        if ($stock < 3) {
            return new ShoppingResponse(
                'operation_applied',
                201,
                'Stock is low'
            );
        }

        return new ShoppingResponse(
            'operation_applied',
            201,
            null
        );
    }
}
