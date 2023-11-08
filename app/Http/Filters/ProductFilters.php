<?php

namespace App\Http\Filters;

class ProductFilters extends BaseFilter
{
    protected function name(string $name = '')
    {
        $this->builder->where('name', 'like', "%{$name}%");
    }

    protected function categories(array $categoryIds = [])
    {
        $this->builder->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories_id', $categoryIds);
        });
    }

    protected function category_name(string $categoryName = '')
    {
        $this->builder->whereHas('categories', function ($q) use ($categoryName) {
            $q->where('name', 'like', "%{$categoryName}%");
        });
    }

    protected function price(array $price = [])
    {
        $this->builder->whereBetween('price', $price);
    }

    protected function published(bool $published = false)
    {
        $this->builder->where('published', '=', $published);
    }

}
