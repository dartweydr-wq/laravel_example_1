<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ResourceCollections\ProductResourceCollection;
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

    /*public function getProductByName(Request $request) : ProductResourceCollection
    {
        $result = $this->repository->getProductsByName($request->name)->get();
        return new ProductResourceCollection($result);
    }

    public function getProductByCategories(Request $request) : ProductResourceCollection
    {
        $result = $this->repository->getProductByCategories($request->categories_id)->get();
        return new ProductResourceCollection($result);
    }

    public function getProductByCategoryName(Request $request) : ProductResourceCollection
    {
        $result = $this->repository->getProductByCategoryName($request->category_name)->get();
        return new ProductResourceCollection($result);
    }

    public function getProductByPrice(Request $request) : ProductResourceCollection
    {
        $result = $this->repository->getProductByPrice($request->price)->get();
        return new ProductResourceCollection($result);
    }*/

    public function getProduct(Request $request) : ProductResourceCollection
    {
        $data = $request->all();
        $result = $this->repository->getProduct($data)->get();
        return new ProductResourceCollection($result);
    }

    public function store(Request $request) : JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'vendor_code' => 'required',
            'price' => 'required',
            'categories_id' => 'required',
        ],[
            'required' => ':attribute - Обязательное поле',
        ],[
            'name' => 'Название продукта',
            'vendor_code' => 'Артикул продукта',
            'price' => 'Цена продукта',
            'categories_id' => 'Категория продукта',
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
