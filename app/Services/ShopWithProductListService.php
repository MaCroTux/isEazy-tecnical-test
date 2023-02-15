<?php

namespace App\Services;

use App\Models\Shop;

class ShopWithProductListService
{
    private Shop $shopModel;

    public function __construct(Shop $shopModel)
    {
        $this->shopModel = $shopModel;
    }

    /**
     * Devuelve un array de tiendas y productos asociados a la tienda
     *
     * @return array
     */
    public function __invoke(): array
    {
        return $this->shopModel
            ->query()
            ->with('products')
            ->get()
            ->toArray();
    }
}
