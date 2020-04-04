<?php

namespace App\Actions\Product;

use App\Actions\Result;
use App\DTO\Product\DestroyDTO;
use App\Proxies\ProductProxy;

class DestroyAction
{
    private ProductProxy $productProxy;

    public function __construct(ProductProxy $productProxy)
    {
        $this->productProxy = $productProxy;
    }

    public function execute(DestroyDTO $destroyDTO): Result
    {
        try {

            $this->productProxy->delete($destroyDTO->product);

            return Result::success();

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
