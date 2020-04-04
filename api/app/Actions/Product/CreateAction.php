<?php

namespace App\Actions\Product;

use App\Actions\Result;
use App\DTO\Product\CreateDTO;
use App\Proxies\ProductProxy;

class CreateAction
{
    private ProductProxy $productProxy;

    public function __construct(ProductProxy $productProxy)
    {
        $this->productProxy = $productProxy;
    }

    public function execute(CreateDTO $createDTO): Result
    {
        try {

            $product = $this->productProxy->create(
                $createDTO->title,
                $createDTO->content
            );

            return Result::success([
                'productId' => $product->id,
            ]);

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
