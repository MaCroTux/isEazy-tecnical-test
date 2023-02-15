<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;

class StoreShopWithProductsController extends Controller
{
    /**
     * Almacena una nueva tienda con array de productos
     *
     * @param StoreShopRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreShopRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $shop = new Shop;
        $shop->setAttribute('name', $requestData['name']);

        $productsToCreate = [];
        $pivotAttribute = [];
        foreach ($requestData['products'] as $product) {
            $productModel = new Product;
            $productModel->setAttribute('name',$product['name']);

            $productsToCreate[] = $productModel;
            $pivotAttribute[] = ['stock' => $product['stock']];
        }

        $shop->save();
        $shop->products()->saveMany($productsToCreate, $pivotAttribute);

        return response()->json([
            'status' => 'saved',
            'data' => $shop->toArray(true)
        ], 201);
    }

}
