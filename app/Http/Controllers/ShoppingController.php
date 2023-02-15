<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingRequest;
use App\Services\ShoppingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ShoppingController extends Controller
{
    private ShoppingService $shoppingService;

    public function __construct(ShoppingService $shoppingService)
    {
        $this->shoppingService = $shoppingService;
    }

    public function __invoke(ShoppingRequest $request): JsonResponse
    {
        $shopId = $request->get('shop_id');
        $productId = $request->get('product_id');
        $units = $request->get('units');

        $shoppingResponse = $this->shoppingService->__invoke($shopId, $productId, $units);

        return response()->json([
            'status' => $shoppingResponse->getStatus(),
            'msg' => $shoppingResponse->getMessage()
        ], $shoppingResponse->getCode());
    }
}
