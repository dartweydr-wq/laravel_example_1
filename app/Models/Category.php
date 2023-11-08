<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    /**
     * Продукты, принадлежащие категории.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_categories', 'categories_id', 'products_id');
    }
}
