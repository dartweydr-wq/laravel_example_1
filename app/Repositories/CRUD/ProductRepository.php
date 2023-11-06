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

    public function getProductsByName(string $productName = ''): Builder
    {
        $builder = Product::where('name', 'like', "%{$productName}%");

        return $builder;
    }

    public function getProductByCategories(array $categories = []): Builder
    {
        $builder = Product::with('categories')
            ->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('categories_id', $categories);
            });

        return $builder;
    }

    public function getProductCategoryByNames(string $categoryName = ''): Builder
    {
        $builder = Product::with('categories')
            ->whereHas('categories', function ($q) use ($categoryName) {
                $q->where('name', 'like', "%{$categoryName}%");
            });

        return $builder;
    }

    public function getProductByPrice(array $productPrice = []): Builder
    {
        $builder = Product::whereBetween('price',$productPrice);

        return $builder;
    }
}
