<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Products\ProductIndexResource;
use App\Http\Resources\API\Products\ProductResource;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;

class ProductController extends ResponseController
{
    public function index(): object
    {
        return ProductIndexResource::collection(Product::with('variations.stock')->withScopes($this->scope())->paginate(10));
    }

    protected function scope(): array
    {
        return [
            'category' => new CategoryScope()
        ];
    }

    public function show(Product $product): object
    {
        $product->load(['variations.type', 'variations.stock', 'variations.product']);
        return new ProductResource($product);
    }
}
