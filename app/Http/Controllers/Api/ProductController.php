<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    public function __construct()
    {

    }
    public function store(Request $request)
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

    public function update($id, Request $request)
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

    public function destroy($id)
    {
        if ($product = Product::find($id)->delete()) {
            return $this->sendResponse($product, 'deleted successfully.');
        }

        return $this->sendError($product, 'deleted error.');
    }
}
