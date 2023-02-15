<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
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
}
