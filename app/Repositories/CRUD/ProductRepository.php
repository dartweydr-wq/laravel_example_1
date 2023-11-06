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

    /*public function getProductsByName(string $productName = ''): Builder
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

    public function getProductByCategoryName(string $categoryName = ''): Builder
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
    }*/

    public function getProduct(array $data) : Builder
    {
        $productName = (array_key_exists('name', $data)) ?  $data['name'] : '';
        $categories = (array_key_exists('categories_id', $data)) ? $data['categories_id'] : [];
        $categoryName = (array_key_exists('categoryName', $data)) ? $data['categoryName'] : '';
        $productPrice = (array_key_exists('productPrice', $data)) ? $data['productPrice'] : [];

        $builder = Product::query()
            ->where('name', 'like', "%{$productName}%")
            ->orWhereBetween('price', $productPrice)
            ->orWhereHas('categories', function (Builder $q) use ($categories, $categoryName) {
                return $q->whereIn('categories_id', $categories)->orWhere('name', 'like', "%{$categoryName}%");
            });

        return $builder;
    }
}
