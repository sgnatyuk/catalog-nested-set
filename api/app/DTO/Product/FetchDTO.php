<?php

namespace App\DTO\Product;

class FetchDTO
{
    public ?string $search;

    public function __construct(?string $search)
    {
        $this->search = $search;
    }
}
