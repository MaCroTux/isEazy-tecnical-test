<?php

namespace App\Http\Controllers;

use App\Services\ShowShopWithProductsService;
use Illuminate\Http\JsonResponse;

class ShowShopWithProductsController extends Controller
{
    private ShowShopWithProductsService $showShopWithProductsService;

    public function __construct(ShowShopWithProductsService $showShopWithProductsService)
    {
        $this->showShopWithProductsService = $showShopWithProductsService;
    }

    /**
     * Devuelve detalle de la tienda, productos y sus respectivos stocks
     *
     * @param int $tiendaId
     * @return JsonResponse
     */
    public function __invoke(int $tiendaId): JsonResponse
    {
        return response()->json(
            $this->showShopWithProductsService->__invoke($tiendaId)
        );
    }
}
