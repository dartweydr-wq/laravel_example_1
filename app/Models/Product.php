<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'vendor_code',
        'price',
        'published',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Категории, принадлежащие продуктам.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'products_id', 'categories_id');
    }
}
