<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends BaseController
{
    public function store(Request $request) : JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
        ],[
            'required' => ':attribute - Обязательное поле',
        ],[
            'name' => 'Название категории',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Category::create($data);

        return $this->sendResponse($product->toArray(), 'created successfully.');
    }

    public function destroy($id) : JsonResponse
    {
        $category = Category::find($id);

        if ($category->products()->first()) {
            return $this->sendError(false, 'Deleted error. Product has been find.');
        }

        $deleteCategory = $category->delete();

        return $this->sendResponse($deleteCategory, 'Deleted successfully.');
    }
}
