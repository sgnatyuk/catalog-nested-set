<?php

namespace App\Fetchers;

use App\Models\Product;
use App\DTO\Product\FetchDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductFetcher
{
    public function fetch(FetchDTO $fetchDTO): Collection
    {
        return Product::query()
            ->when($fetchDTO->search, function (Builder $query) use ($fetchDTO) {
                $query->where('title', 'like', "%$fetchDTO->search%");
            })
            ->get();
    }
}
