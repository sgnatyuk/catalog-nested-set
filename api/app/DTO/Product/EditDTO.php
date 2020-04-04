<?php

namespace App\DTO\Product;

use App\Models\Product;

final class EditDTO
{
    public Product $product;

    public ?int $categoryId;
    public ?int $imageId;
    public string $title;
    public string $content;

    public function __construct(
        Product $product,
        ?int $categoryId,
        ?int $imageId,
        string $title,
        string $content
    )
    {
        $this->product = $product;

        $this->categoryId = $categoryId;
        $this->imageId = $imageId;
        $this->title = $title;
        $this->content = $content;
    }
}
