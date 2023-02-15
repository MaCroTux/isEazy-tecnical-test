<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\JsonResponse;

class GetShopsWithProductsController extends Controller
{
    /**
     * Listado de tiendas con productos relacionados
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json(
            Shop::query()->with('products')->get()->toArray()
        );
    }
}
