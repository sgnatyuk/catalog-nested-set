<?php

namespace App\Http\Controllers;

use App\Services\ImageService;

// Models
use App\Models\{
    Category,
    Product
};

class HomeController
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        return Category::query()->get()->toTree();
    }

    public function getProducts(Category $category)
    {
        return $category->products->map(function (Product $product) {

            return [
                'id'      => $product->id,
                'title'   => $product->title,
                'content' => $product->content,
                'image'   => $this->imageService->fit($product->image->name, 64, 64),
            ];
        });
    }
}
