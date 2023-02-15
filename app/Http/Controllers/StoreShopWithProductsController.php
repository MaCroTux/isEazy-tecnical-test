<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Services\StoreShopWithProductService;
use Illuminate\Http\JsonResponse;

class StoreShopWithProductsController extends Controller
{
    private StoreShopWithProductService $storeShopWithProductService;

    public function __construct(StoreShopWithProductService $storeShopWithProductService)
    {
        $this->storeShopWithProductService = $storeShopWithProductService;
    }

    /**
     * Almacena una nueva tienda con array de productos
     *
     * @param StoreShopRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreShopRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        return response()->json($this->storeShopWithProductService->__invoke(
            $requestData['name'],
            $requestData['products']
        ), 201);
    }

}
