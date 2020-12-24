<?php

namespace App\Http\Controllers\API\Categories;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Categories\CategoryResource;
use App\Http\Resources\API\Categories\CategoryWithProductsResource;
use App\Models\Category;

class CategoryController extends ResponseController
{
    public function index()
    {
        $message['result'] = CategoryResource::collection(
            Category::parents()->with('children.children')->ordered()->get()
        );
        return $this->response($message);
    }

    public function show(Category $category)
    {
        return new CategoryWithProductsResource($category);
    }


}
