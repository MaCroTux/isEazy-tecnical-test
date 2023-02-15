<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;

class UpdateShopController extends Controller
{
    public function __invoke(UpdateShopRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $shopToEdit = Shop::query()->findOrFail($requestData['id']);
        $shopToEdit->setAttribute('name', $request->get('name'));
        $shopToEdit->update();

        return response()->json(['status' => 'edited']);
    }
}
