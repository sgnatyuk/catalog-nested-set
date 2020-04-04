<?php

namespace App\DTO\Category;

use App\Models\Category;

final class DestroyDTO
{
    public Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}
