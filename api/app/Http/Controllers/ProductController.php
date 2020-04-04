<?php

namespace App\Http\Controllers;

use App\Actions\Product\CreateAction;
use App\Actions\Product\DestroyAction;
use App\Actions\Product\EditAction;
use App\DTO\Product\CreateDTO;
use App\DTO\Product\DestroyDTO;
use App\DTO\Product\EditDTO;
use App\DTO\Product\FetchDTO;
use App\Fetchers\ProductFetcher;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProductController
{
    public function index(Request $request, ProductFetcher $productFetcher)
    {
        return ProductCollection::collection(
            $productFetcher->fetch(new FetchDTO(
                $request->input('search')
            ))
        );
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(StoreRequest $request, CreateAction $createAction)
    {
        $createDTO = new CreateDTO(
            $request->input('title'),
            $request->input('content')
        );

        $result = $createAction->execute($createDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        return new Response(null, Response::HTTP_CREATED, [
            'X-Created-Resource-Id' => $result->getBody()['productId'],
        ]);
    }

    public function update(UpdateRequest $request, Product $product, EditAction $editAction)
    {
        $editDTO = new EditDTO(
            $product,
            $request->input('categoryId'),
            $request->input('imageId'),
            $request->input('title'),
            $request->input('content'),
        );

        $result = $editAction->execute($editDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(Product $product, DestroyAction $destroyAction)
    {
        $destroyDTO = new DestroyDTO($product);

        $result = $destroyAction->execute($destroyDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
