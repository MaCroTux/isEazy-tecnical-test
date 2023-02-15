<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingRequest;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ShoppingController extends Controller
{
    public function __invoke(ShoppingRequest $request): JsonResponse
    {
        $shopId = $request->get('shop_id');
        $productId = $request->get('product_id');
        $units = $request->get('units');

        /** @var Shop $shop */
        $shop = Shop::query()->findOrFail($shopId);
        $product = $shop->products()->withPivot('stock')->findOrFail($productId);
        $stock = (int)$product->getOriginal('pivot_stock');

        if ($stock === 0 || $stock < $units) {
            return response()->json([
                'status' => 'operation_no_applied',
                'msg' => 'Out of stock',
            ], 402);
        }

        $shop->products()->updateExistingPivot($product->getAttribute('id'), ['stock' => $stock - $units]);

        if ($stock < 3) {
            return response()->json([
                'status' => 'operation_applied',
                'msg' => 'Stock is low',
            ], 201);
        }

        return response()->json([
            'status' => 'operation_applied',
        ], 201);
    }
}
