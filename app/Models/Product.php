<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, Stock::class)
            ->withPivot('stock');
    }

    /**
     * Generamos un método toArray custom para poder devolver los datos que necesitamos en las respuestas
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getAttribute('id'),
            'name' => $this->getAttribute('name'),
            'stock' => $this->getOriginal('pivot_stock'),
        ];
    }
}
