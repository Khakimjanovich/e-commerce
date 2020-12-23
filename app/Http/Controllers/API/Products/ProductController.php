<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Products\ProductIndexResource;
use App\Http\Resources\API\Products\ProductResource;
use App\Models\API\Product;
use App\Scoping\Scopes\CategoryScope;

class ProductController extends ResponseController
{
    public function index()
    {
        $product = Product::with('variations.stock')->withScopes($this->scope())->paginate(10);
        $message['result'] = ProductIndexResource::collection($product);
        return $this->response($message);
    }

    public function show(Product $product)
    {
        $product->load(['variations.type','variations.stock','variations.product']);
        $message['result'] = new ProductResource($product);
        return $this->response($message);
    }


    protected function scope(){
        return [
            'category' => new CategoryScope()
        ];
    }
}
