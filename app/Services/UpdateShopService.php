<?php

namespace App\Services;

use App\Models\Shop;

class UpdateShopService
{
    private Shop $shopModel;

    public function __construct(Shop $shopModel)
    {
        $this->shopModel = $shopModel;
    }

    /**
     * Actualiza un producto
     *
     * @param int $id
     * @param string $name
     * @return string[]
     */
    public function __invoke(int $id, string $name): array
    {
        $shopToEdit = $this->shopModel->query()->findOrFail($id);
        $shopToEdit->setAttribute('name', $name);
        $shopToEdit->update();

        return ['status' => 'edited'];
    }
}
