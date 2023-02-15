<?php

namespace App\Http\Controllers;

use App\Models\Shop;
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
}
