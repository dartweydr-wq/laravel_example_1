<?php

namespace App\Http\Resources\ResourceCollections;

use App\Http\Resources\Resource\ProductResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ProductResourceCollection extends ResourceCollection
{
    public $collects = ProductResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
