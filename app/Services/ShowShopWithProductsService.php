<?php

namespace App\Services;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;

class ShowShopWithProductsService
{
    private Shop $shopModel;

    public function __construct(Shop $shopModel)
    {
        $this->shopModel = $shopModel;
    }

    /**
     * Devuelve el detalle de la tienda y todos sus productos con número de stock
     *
     * @param int $tiendaId
     * @return array
     */
    public function __invoke(int $tiendaId): array
    {
        /** @var Shop $shop */
        $shop = $this->shopModel::query()->with('products')->find($tiendaId);

        return $this->isNotEmpty($shop)
            ? $shop->toArray(true)
            : [];
    }

    private function isNotEmpty(Shop|Collection|null $shop): bool
    {
        return !empty($shop);
    }
}
