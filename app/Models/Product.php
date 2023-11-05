<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vendor_code',
        'price',
    ];

    /**
     * Категории, принадлежащие продуктам.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'products_id', 'categories_id');
    }
}
