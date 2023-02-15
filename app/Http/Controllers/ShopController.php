<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ShopController extends Controller
{
    /**
     * Listado de tiendas con productos relacionados
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Shop::query()->with('products')->get()->toArray()
        );
    }

    /**
     * Devuelve detalle de la tienda, productos y sus respectivos stocks
     *
     * @param int $tiendaId
     * @return JsonResponse
     */
    public function show(int $tiendaId): JsonResponse
    {
        /** @var Shop $shop */
        $shop = Shop::query()->with('products')->find($tiendaId);

        return response()->json(
            $this->isNotEmpty($shop)
                ? $shop->toArray(true)
                : []
        );
    }

    private function isNotEmpty(Shop|Collection|null $shop): bool
    {
        return !empty($shop);
    }

    public function store(StoreShopRequest $request): JsonResponse
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

    public function update(UpdateShopRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $shopToEdit = Shop::query()->findOrFail($requestData['id']);
        $shopToEdit->setAttribute('name', $request->get('name'));
        $shopToEdit->update();

        return response()->json(['status' => 'edited']);
    }
}
