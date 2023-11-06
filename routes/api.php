<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api\V1')->group(function () {

    Route::post('products',[ProductController::class, 'store']);
    Route::put('products/{id}',[ProductController::class, 'update']);
    Route::delete('products/{id}',[ProductController::class, 'destroy']);
    Route::get('products/product-names',[ProductController::class, 'getProductByName']);
    Route::get('products/product-categories',[ProductController::class, 'getProductByCategories']);
    Route::get('products/product-category-names',[ProductController::class, 'getProductCategoryByNames']);
    Route::get('products/product-prices',[ProductController::class, 'getProductByPrice']);

    Route::post('categories',[CategoryController::class, 'store']);
    Route::delete('categories/{id}',[CategoryController::class, 'destroy']);
});
