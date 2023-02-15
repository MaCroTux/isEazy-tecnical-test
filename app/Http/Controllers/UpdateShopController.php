<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateShopRequest;
use App\Services\UpdateShopService;
use Illuminate\Http\JsonResponse;

class UpdateShopController extends Controller
{
    private UpdateShopService $updateShopService;

    public function __construct(UpdateShopService $updateShopService)
    {
        $this->updateShopService = $updateShopService;
    }

    public function __invoke(UpdateShopRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        return response()->json(
            $this->updateShopService->__invoke(
                $requestData['id'],
                $requestData['name']
            )
        );
    }
}
