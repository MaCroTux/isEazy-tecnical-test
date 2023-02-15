<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Shop;

class StoreShopWithProductService
{
    private Shop $shopModel;
    private Product $productModel;

    public function __construct(Shop $shopModel, Product $productModel)
    {
        $this->shopModel = $shopModel;
        $this->productModel = $productModel;
    }

    /**
     * Almacena una tienda y un listado de productos dados
     *
     * @param string $shopName
     * @param array[] $shopProducts
     * @return array
     */
    public function __invoke(string $shopName, array $shopProducts): array
    {
        $this->shopModel->setAttribute('name', $shopName);

        $productsToCreate = [];
        $pivotAttribute = [];
        foreach ($shopProducts as $product) {
            $this->productModel->setAttribute('name',$product['name']);

            $productsToCreate[] = $this->productModel;
            $pivotAttribute[] = ['stock' => $product['stock']];
        }

        $this->shopModel->save();
        $this->shopModel->products()->saveMany($productsToCreate, $pivotAttribute);

        return [
            'status' => 'saved',
            'data' => $this->shopModel->toArray(true)
        ];
    }
}
