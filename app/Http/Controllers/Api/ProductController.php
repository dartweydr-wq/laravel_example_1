<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Filters\ProductFilters;
use App\Http\Resources\Resource\ProductResource;
use App\Models\Product;
use App\Repositories\CRUD\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getProducts(Request $request) : ProductResource
    {
        $products = (new ProductFilters($request, $this->repository->getProduct()))->apply()->get();

        $result = [
            'products' => $products,
        ];

        return new ProductResource($result);
    }

    public function store(Request $request) : JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required'],
            'vendor_code' => ['required'],
            'price' => ['required'],
            'categories_id' => ['required'],
            'published' => ['required','boolean'],
        ],[
            'required' => ':attribute - Обязательное поле',
        ],[
            'name' => 'Название товара',
            'vendor_code' => 'Артикул товара',
            'price' => 'Цена товара',
            'categories_id' => 'Категория товара',
            'published' => 'Опубликовать товар',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($data);

        if (array_key_exists('categories_id', $data)) {
            Product::find($product->id)->categories()->sync($data['categories_id']);
        }

        return $this->sendResponse($product->toArray(), 'created successfully.');
    }

    public function update($id, Request $request) : JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'vendor_code' => 'required',
            'price' => 'required',
        ],[
            'required' => ':attribute - Обязательное поле',
        ],[
            'name' => 'Название продукта',
            'vendor_code' => 'Артикул продукта',
            'price' => 'Цена продукта',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::find($id)->update($data);

        return $this->sendResponse($product, 'updated successfully.');
    }

    public function destroy($id) : JsonResponse
    {
        if ($product = Product::find($id)->delete()) {
            return $this->sendResponse($product, 'deleted successfully.');
        }

        return $this->sendError($product, 'deleted error.');
    }
}
