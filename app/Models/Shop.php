<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    use HasFactory;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, Stock::class)
            ->withPivot('stock');
    }

    /**
     * Generamos un método toArray custom para poder devolver los datos que necesitamos en las respuestas
     *
     * @param bool $withStock
     * @return array
     */
    public function toArray(bool $withStock = false): array
    {
        return [
            'id' => $this->getAttribute('id'),
            'name' => $this->getAttribute('name'),
            'products' => array_map(function (array $product) use ($withStock) {
                $optionalDataStock = $withStock === true ? ['stock' => $product['stock']]: [];
                return [
                        'id' => $product['id'],
                        'name' => $product['name'],
                    ] + $optionalDataStock;
            }, $this->getAttribute('products')->toArray() ?? [])
        ];
    }
}
