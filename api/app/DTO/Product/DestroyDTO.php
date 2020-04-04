<?php

namespace App\DTO\Product;

use App\Models\Product;

final class DestroyDTO
{
    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
