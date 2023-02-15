<?php

namespace App\Http\Controllers;

use App\Services\ShopWithProductListService;
use Illuminate\Http\JsonResponse;

class GetShopsWithProductsController extends Controller
{
    private ShopWithProductListService $shopWithProductListService;

    public function __construct(ShopWithProductListService $shopWithProductListService)
    {
        $this->shopWithProductListService = $shopWithProductListService;
    }

    /**
     * Listado de tiendas con productos relacionados
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json(
            $this->shopWithProductListService->__invoke()
        );
    }
}
