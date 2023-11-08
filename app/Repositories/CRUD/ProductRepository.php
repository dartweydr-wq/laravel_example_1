<?php

namespace App\Repositories\CRUD;

use App\Models\Product;
use App\Repositories\CRUDRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements CRUDRepositoryInterface
{

    public function getModelById(int $id): ?Model
    {
        return Product::where('id', '=', $id)->first();
    }

    public function getModelsQB(): Builder
    {
        return Product::query()->orderBy('id', 'asc');
    }

    public function getProduct() : Builder
    {
        return Product::with(['categories']);
    }
}
